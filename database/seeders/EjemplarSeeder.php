<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ejemplar;
use App\Models\Libro;

class EjemplarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $libros = Libro::all();

        $ubicaciones = [
            'A1', 'A2', 'A3',
            'B1', 'B2',
            'C1', 'C2', 'D1'
        ];

        for ($i = 0; $i < 8; $i++) {

            Ejemplar::create([
                'libro_id' => $libros[$i % $libros->count()]->id,
                'ubicacion' => $ubicaciones[$i],
            ]);
        }
    }
}
