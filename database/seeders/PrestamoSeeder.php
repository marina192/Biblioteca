<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prestamo;
use App\Models\Ejemplar;
use App\Models\User;
use Carbon\Carbon;

class PrestamoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ejemplares = Ejemplar::all();
        $lectores = User::role('lector')->get();

        /*
        |--------------------------------------------------------------------------
        | PRÉSTAMOS ACTIVOS (2)
        |--------------------------------------------------------------------------
        */

        Prestamo::create([
            'ejemplar_id' => $ejemplares[0]->id,
            'user_id' => $lectores[0]->id,
            'fecha_prestamo' => Carbon::parse('2026-05-15'),
            'fecha_devolucion_esperada' => Carbon::parse('2026-05-30'),
            'fecha_devolucion' => null,
        ]);

        $ejemplares[0]->update([
            'estado' => 'prestado'
        ]);

        Prestamo::create([
            'ejemplar_id' => $ejemplares[1]->id,
            'user_id' => $lectores[0]->id,
            'fecha_prestamo' => Carbon::parse('2026-05-20'),
            'fecha_devolucion_esperada' => Carbon::parse('2026-06-04'),
            'fecha_devolucion' => null,
        ]);

        $ejemplares[1]->update([
            'estado' => 'prestado'
        ]);

        /*
        |--------------------------------------------------------------------------
        | PRÉSTAMOS EXPIRADOS (3)
        |--------------------------------------------------------------------------
        */

        Prestamo::create([
            'ejemplar_id' => $ejemplares[2]->id,
            'user_id' => $lectores[0]->id,
            'fecha_prestamo' => Carbon::parse('2026-04-20'),
            'fecha_devolucion_esperada' => Carbon::parse('2026-05-05'),
            'fecha_devolucion' => null,
        ]);

        $ejemplares[2]->update([
            'estado' => 'prestado'
        ]);

        Prestamo::create([
            'ejemplar_id' => $ejemplares[3]->id,
            'user_id' => $lectores[0]->id,
            'fecha_prestamo' => Carbon::parse('2026-04-25'),
            'fecha_devolucion_esperada' => Carbon::parse('2026-05-10'),
            'fecha_devolucion' => null,
        ]);

        $ejemplares[3]->update([
            'estado' => 'prestado'
        ]);

        Prestamo::create([
            'ejemplar_id' => $ejemplares[4]->id,
            'user_id' => $lectores[0]->id,
            'fecha_prestamo' => Carbon::parse('2026-05-01'),
            'fecha_devolucion_esperada' => Carbon::parse('2026-05-16'),
            'fecha_devolucion' => null,
        ]);

        $ejemplares[4]->update([
            'estado' => 'prestado'
        ]);

        /*
        |--------------------------------------------------------------------------
        | HISTORIAL (7)
        |--------------------------------------------------------------------------
        */

        for ($i = 0; $i < 7; $i++) {

            $fechaPrestamo = Carbon::parse('2026-03-01')->addDays($i * 5);

            Prestamo::create([
                'ejemplar_id' => $ejemplares[5 + ($i % 3)]->id,
                'user_id' => $lectores[0]->id,
                'fecha_prestamo' => $fechaPrestamo,
                'fecha_devolucion_esperada' => $fechaPrestamo->copy()->addDays(15),
                'fecha_devolucion' => $fechaPrestamo->copy()->addDays(12),
            ]);

            $ejemplares[5 + ($i % 3)]->update([
                'estado' => 'disponible'
            ]);
        }
    }
}
