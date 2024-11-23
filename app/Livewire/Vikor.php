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
        $pesantrenData = Pesantren::with(['facilities', 'extracurriculars'])->get();

        // Prepare criteria data with default values
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

        // Normalize and calculate VIKOR scores
        $normalizedData = $this->normalizeData($criteriaData);
        $this->results = $this->calculateQValues($normalizedData);

        // store vikor result history
        $this->storeVikorResults($this->results);
    }

    private function normalizeData($data)
    {
        $criteria = ['akreditasi', 'jumlah_santri', 'biaya_bulanan', 'fasilitas', 'ekstrakurikuler'];

        $normalizedData = [];

        foreach ($data as $item) {
            // Initialize each normalized item with the same 'id' and 'name'
            $normalizedItem = [
                'id' => $item['id'],
                'name' => $item['name']
            ];

            foreach ($criteria as $criterion) {
                // Determine best and worst values based on criterion type
                if ($criterion != 'biaya_bulanan') {
                    $worst = collect($data)->min($criterion);
                    $best = collect($data)->max($criterion);
                } else {
                    $worst = collect($data)->max($criterion);
                    $best = collect($data)->min($criterion);
                }

                // Normalize the data for each criterion
                $normalizedItem[$criterion] = $best == $worst ? 0 : ($best - $item[$criterion]) / ($best - $worst);
            }

            // Add the normalized item to the new array
            $normalizedData[] = $normalizedItem;
        }
        // dd($normalizedData);
        // Return the new normalized data
        $this->normalizedResults = $normalizedData;
        return $normalizedData;
    }

    private function calculateQValues($data)
    {

        $dataCollection = collect($data);

        $weights = [
            'akreditasi' => $this->selectedBobotAkreditasi,
            'jumlah_santri' => $this->selectedBobotJumlahSantri,
            'biaya_bulanan' => $this->selectedBobotBiayaBulanan,
            'fasilitas' => $this->selectedBobotFasilitas,
            'ekstrakurikuler' => $this->selectedBobotEkstrakurikuler
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

        // Prevent division by zero for Q calculation
        foreach ($data as $item) {
            $S_val = $S[$item['id']];
            $R_val = $R[$item['id']];

            // Calculate Q with division by zero protection
            $S_denominator = $S_neg - $S_star;
            $R_denominator = $R_neg - $R_star;

            $S_term = $S_denominator != 0 ? ($S_val - $S_star) / $S_denominator : 0;
            $R_term = $R_denominator != 0 ? ($R_val - $R_star) / $R_denominator : 0;

            $Q[$item['id']] = 0.5 * $S_term + 0.5 * $R_term;
        }

        // dd($data);
        return collect(array_map(function ($item) use ($Q) {
            $item['Q'] = $Q[$item['id']];
            return $item;
        }, $data))->sortBy('Q')->values()->all();
    }

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
