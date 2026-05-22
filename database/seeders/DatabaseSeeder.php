<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RolesSeeder::class,
        ]);

        $admin = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'is_super_admin' => true,
        ]);

        $admin->assignRole('admin');

        $lector = User::factory()->create([
            'name' => 'Lector',
            'email' => 'lector@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $lector->assignRole('lector');

        $this->call([
            CategoriaSeeder::class,
            LibroSeeder::class,
            EjemplarSeeder::class,
            PrestamoSeeder::class,
        ]);
    }
}
