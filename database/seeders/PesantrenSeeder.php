<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Pesantren;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PesantrenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Pesantren::insert([
            [
                'name' => 'Pesantren Al-Hidayah',
                'address' => 'Jl. Raya Bogor No. 123, Jakarta Selatan',
                'akreditasi' => 'A',
                'total_students' => 500,
                'biaya_bulanan' => 700000
            ],
            [
                'name' => 'Pesantren Al-Khairat',
                'address' => 'Jl. Pemuda No. 456, Jakarta Utara',
                'akreditasi' => 'B',
                'total_students' => 300,
                'biaya_bulanan' => 500000
            ],
            [
                'name' => 'Pesantren Al-Muttaqin',
                'address' => 'Jl. Sudirman No. 789, Jakarta Pusat',
                'akreditasi' => 'A',
                'total_students' => 400,
                'biaya_bulanan' => 350000
            ],
        ]);
        Facility::insert([
            'pesantren_id' => 1,
            'name' => 'Keamanan',
            'description' => 'Keamanan dijaga oleh satpan 24 jam'
        ]);
    }
}
