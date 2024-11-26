<?php

namespace App\Livewire;

use App\Models\Extracurricular;
use App\Models\Facility;
use App\Models\LearningMethod;
use App\Models\Pesantren;
use App\Models\VikorResultHistory;
use Livewire\Component;

class Vikor extends Component
{
    // pre-defined weights
    public $selectedBobotAkreditasi = 1;
    public $selectedBobotJumlahSantri = 1;
    public $selectedBobotBiayaBulanan = 1;
    public $selectedBobotFasilitas = 1;
    public $selectedBobotEkstrakurikuler = 1;

    public $alternativeResults = [];
    public $normalizedResults = [];
    public $results = [];

    public function calculateVikor()
    {
        // data awal
        $pesantrenData = Pesantren::with(['facilities', 'extracurriculars'])->get();

        // Nilai kritera
        $criteriaData = $pesantrenData->map(function ($pesantren) {
            return [
                'id' => $pesantren->id,
                'name' => $pesantren->name,
                'akreditasi' => $pesantren->akreditasi == 'A' ? 4 : ($pesantren->akreditasi == 'B' ? 3 : ($pesantren->akreditasi == 'C' ? 2 : ($pesantren->akreditasi == 'Akreditasi Unggul' ? 5 : 1))),
                'jumlah_santri' => $pesantren->total_students <= 200 ? 1 : ($pesantren->total_students <= 300 ? 2 : ($pesantren->total_students <= 400 ? 3 : ($pesantren->total_students <= 500 ? 4 : 5))),
                'biaya_bulanan' => $pesantren->biaya_bulanan <= 75000 ? 5 : ($pesantren->biaya_bulanan <= 200000 ? 4 : ($pesantren->biaya_bulanan <= 300000 ? 3 : ($pesantren->biaya_bulanan <= 400000 ? 2 : 1))),
                'fasilitas' => $pesantren->facilities->count() <= 3 ? 1 : ($pesantren->facilities->count() <= 5 ? 2 : ($pesantren->facilities->count() <= 8 ? 3 : ($pesantren->facilities->count() <= 12 ? 4 : 5))),
                'ekstrakurikuler' => $pesantren->extracurriculars->count() <= 1 ? 1 : ($pesantren->extracurriculars->count() <= 4 ? 2 : ($pesantren->extracurriculars->count() <= 7 ? 3 : ($pesantren->extracurriculars->count() <= 9 ? 4 : 5))),
            ];
        });
        $this->alternativeResults = $criteriaData;

        // Normalisasi
        $normalizedData = $this->normalizeData($criteriaData);
        // perhitungan selanjutnya
        $this->results = $this->calculateQValues($normalizedData);

        // store vikor result history
        $this->storeVikorResults($this->results);
    }

    private function normalizeData($data)
    {
        $criteria = ['akreditasi', 'jumlah_santri', 'biaya_bulanan', 'fasilitas', 'ekstrakurikuler'];

        $normalizedData = [];

        foreach ($data as $item) {
            $normalizedItem = [
                'id' => $item['id'],
                'name' => $item['name']
            ];

            foreach ($criteria as $criterion) {
                $worst = collect($data)->min($criterion);
                $best = collect($data)->max($criterion);
                // Rumus Normalisasi
                $normalizedItem[$criterion] = $best == $worst ? 0 : ($best - $item[$criterion]) / ($best - $worst);
            }

            $normalizedData[] = $normalizedItem;
        }
        $this->normalizedResults = $normalizedData;
        return $normalizedData;
    }

    private function calculateQValues($data)
    {

        $dataCollection = collect($data);
        // rumus bobot
        $total_w = $this->selectedBobotAkreditasi + $this->selectedBobotJumlahSantri + $this->selectedBobotBiayaBulanan + $this->selectedBobotFasilitas + $this->selectedBobotEkstrakurikuler;
        $weights = [
            'akreditasi' => $this->selectedBobotAkreditasi / $total_w,
            'jumlah_santri' => $this->selectedBobotJumlahSantri / $total_w,
            'biaya_bulanan' => $this->selectedBobotBiayaBulanan / $total_w,
            'fasilitas' => $this->selectedBobotFasilitas / $total_w,
            'ekstrakurikuler' => $this->selectedBobotEkstrakurikuler / $total_w
        ];

        // Calculate the minimum and maximum values for each criterion
        $f_star = [
            'akreditasi' => $dataCollection->min('akreditasi'),
            'jumlah_santri' => $dataCollection->min('jumlah_santri'),
            'biaya_bulanan' => $dataCollection->min('biaya_bulanan'),
            'fasilitas' => $dataCollection->min('fasilitas'),
            'ekstrakurikuler' => $dataCollection->min('ekstrakurikuler'),
        ];

        $f_neg = [
            'akreditasi' => $dataCollection->max('akreditasi'),
            'jumlah_santri' => $dataCollection->max('jumlah_santri'),
            'biaya_bulanan' => $dataCollection->max('biaya_bulanan'),
            'fasilitas' => $dataCollection->max('fasilitas'),
            'ekstrakurikuler' => $dataCollection->max('ekstrakurikuler'),
        ];

        $S = [];
        $R = [];
        $Q = [];

        // hitung nilai R dan S
        foreach ($data as $item) {
            $S_val = 0;
            $R_val = -INF;

            foreach ($weights as $criterion => $weight) {
                $f = $item[$criterion];
                // Ensure no division by zero
                if ($f_neg[$criterion] != $f_star[$criterion]) {
                    $s = $weight * ($f - $f_star[$criterion]) / ($f_neg[$criterion] - $f_star[$criterion]);
                } else {
                    $s = 0;
                }

                $S_val += $s;
                $R_val = max($R_val, $s);
            }

            $S[$item['id']] = $S_val;
            $R[$item['id']] = $R_val;
        }

        $S_star = min($S);
        $S_neg = max($S);
        $R_star = min($R);
        $R_neg = max($R);
        // nilai R dan S selesai


        // perangkinang nilai Q
        foreach ($data as $item) {
            $S_val = $S[$item['id']];
            $R_val = $R[$item['id']];

            $S_denominator = $S_neg - $S_star;
            $R_denominator = $R_neg - $R_star;

            $S_term = $S_denominator != 0 ? ($S_val - $S_star) / $S_denominator : 0;
            $R_term = $R_denominator != 0 ? ($R_val - $R_star) / $R_denominator : 0;

            $Q[$item['id']] = 0.5 * $S_term + 0.5 * $R_term;
        }

        // kirim data akhir ke tampilan
        return collect(array_map(function ($item) use ($Q) {
            $item['Q'] = $Q[$item['id']];
            return $item;
        }, $data))->sortBy('Q')->values()->all();
    }

    // simpan data hasil perhitungan vikor
    private function storeVikorResults($sortedResults)
    {
        foreach ($sortedResults as $rank => $result) {
            VikorResultHistory::create([
                'pesantren_id' => $result['id'],
                'vikor_score' => $result['Q'],
                'rank' => $rank + 1, // Rank starts at 1
                'calculated_at' => now(),
            ]);
        }
    }


    public function render()
    {
        return view('livewire.vikor', ['results' => $this->results, 'alternativeResults' => $this->alternativeResults, 'normalizedResults' => $this->normalizedResults]);
    }
}
