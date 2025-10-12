<?php

namespace Database\Seeders;

use App\Models\Eskul;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Cabangeskul extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run()
{
    $cabangs = ['Futsal', 'Basket', 'Pramuka', 'Paskibra', 'IT', 'B.Jepang', 'B.Korea'];

    foreach ($cabangs as $cabang) {
        Eskul::create([
            'cabang_eskul' => $cabang,
            'hari' => 'senin',
            'waktu' => '12:00',
            'tempat' => 'sekolah'
        ]);
    }
}
}
