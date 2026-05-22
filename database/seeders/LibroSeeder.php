<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Libro;
use App\Models\Categoria;

class LibroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $libro1 = Libro::create([
            'titulo' => 'Harry Potter y la Piedra Filosofal',
            'autor' => 'J.K. Rowling',
            'sinopsis' => 'Un joven descubre que es mago y entra a Hogwarts.',
            'editorial' => 'Salamandra',
            'fecha_publicacion' => '1997-06-26',
        ]);

        $libro2 = Libro::create([
            'titulo' => 'Dune',
            'autor' => 'Frank Herbert',
            'sinopsis' => 'Una lucha por el control del planeta Arrakis.',
            'editorial' => 'Chilton Books',
            'fecha_publicacion' => '1965-08-01',
        ]);

        $libro3 = Libro::create([
            'titulo' => 'Drácula',
            'autor' => 'Bram Stoker',
            'sinopsis' => 'La historia clásica del famoso vampiro.',
            'editorial' => 'Archibald Constable and Company',
            'fecha_publicacion' => '1897-05-26',
        ]);

        $libro4 = Libro::create([
            'titulo' => 'Orgullo y Prejuicio',
            'autor' => 'Jane Austen',
            'sinopsis' => 'Una historia romántica en la Inglaterra del siglo XIX.',
            'editorial' => 'T. Egerton',
            'fecha_publicacion' => '1813-01-28',
        ]);

        $libro5 = Libro::create([
            'titulo' => 'Percy Jackson y el ladrón del rayo',
            'autor' => 'Rick Riordan',
            'sinopsis' => 'Un adolescente descubre que es hijo de un dios griego.',
            'editorial' => 'Disney Hyperion',
            'fecha_publicacion' => '2005-06-28',
        ]);

        // Relación categorías
        $libro1->categorias()->attach(
            Categoria::where('nombre', 'Fantasía')->first()->id
        );

        $libro2->categorias()->attach([
            Categoria::where('nombre', 'Ciencia Ficción')->first()->id,
            Categoria::where('nombre', 'Aventura')->first()->id,
        ]);

        $libro3->categorias()->attach(
            Categoria::where('nombre', 'Terror')->first()->id
        );

        $libro4->categorias()->attach(
            Categoria::where('nombre', 'Romance')->first()->id
        );

        $libro5->categorias()->attach([
            Categoria::where('nombre', 'Fantasía')->first()->id,
            Categoria::where('nombre', 'Aventura')->first()->id,
        ]);
    }
}
