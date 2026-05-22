<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Fantasía',
                'descripcion' => 'Mundos mágicos, criaturas fantásticas y aventuras épicas.',
            ],
            [
                'nombre' => 'Ciencia Ficción',
                'descripcion' => 'Historias futuristas, espaciales y tecnológicas.',
            ],
            [
                'nombre' => 'Terror',
                'descripcion' => 'Relatos oscuros, suspenso y horror.',
            ],
            [
                'nombre' => 'Romance',
                'descripcion' => 'Historias de amor y relaciones.',
            ],
            [
                'nombre' => 'Aventura',
                'descripcion' => 'Viajes, exploraciones y desafíos emocionantes.',
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
