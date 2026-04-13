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
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('12345'),
                'kelas' => 'XII',
                'jurusan' => 'PPLG',
            ]);
        }

        // User harus register terlebih dahulu untuk akses aplikasi
        
        // Initialize book stocks
        $this->call(BookStockSeeder::class);
    }
}
