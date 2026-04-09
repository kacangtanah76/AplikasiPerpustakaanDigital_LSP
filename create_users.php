<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = [
    ['name' => 'Ahsan Nugraha', 'kelas' => 'X', 'jurusan' => 'PPLG', 'password' => 'password123'],
    ['name' => 'Bella Rista', 'kelas' => 'XI', 'jurusan' => 'Farmasi', 'password' => 'password123'],
    ['name' => 'Citra Dewi', 'kelas' => 'XII', 'jurusan' => 'AnalisKimia', 'password' => 'password123'],
    ['name' => 'Doni Pratama', 'kelas' => 'XI', 'jurusan' => 'PPLG', 'password' => 'password123'],
    ['name' => 'Eka Putri', 'kelas' => 'X', 'jurusan' => 'Farmasi', 'password' => 'password123'],
];

foreach ($users as $userData) {
    $email = strtolower(str_replace(' ', '', $userData['name'])) . '@student.local';
    
    User::updateOrCreate(
        ['email' => $email],
        [
            'name' => $userData['name'],
            'email' => $email,
            'password' => Hash::make($userData['password']),
            'kelas' => $userData['kelas'],
            'jurusan' => $userData['jurusan'],
            'role' => 'user',
        ]
    );
    
    echo "✓ User '{$userData['name']}' berhasil dibuat\n";
}

echo "\nTotal user: " . User::where('role', 'user')->count() . "\n";
