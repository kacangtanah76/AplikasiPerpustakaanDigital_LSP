<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

try {
    $user = User::create([
        'name' => 'admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('12345'),
        'role' => 'admin',
        'kelas' => '12',
        'jurusan' => 'IPA',
    ]);
    echo "✅ Admin user created successfully!\n";
    echo "Email: admin@gmail.com\n";
    echo "Password: 12345\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
