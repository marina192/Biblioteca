<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
