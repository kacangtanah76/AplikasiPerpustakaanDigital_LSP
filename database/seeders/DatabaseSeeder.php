<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        if (!User::where('name', 'Admin')->exists()) {
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'kelas' => 'XII',
                'jurusan' => 'PPLG',
            ]);
        }

        // User harus register terlebih dahulu untuk akses aplikasi
    }
}
