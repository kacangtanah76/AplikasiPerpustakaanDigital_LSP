<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Delete existing test user
User::where('email', 'user@example.com')->delete();

// Create test user
User::create([
    'name' => 'Siswa Test',
    'email' => 'user@example.com',
    'password' => Hash::make('password123'),
    'role' => 'user',
    'kelas' => 'XI',
    'jurusan' => 'IPS',
]);

echo "User test berhasil dibuat!\n";
