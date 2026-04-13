<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\PeminjamanBuku;
use App\Models\BookStock;
use App\Models\User;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get sample data
$bookStocks = BookStock::all();
$users = User::where('role', '!=', 'admin')->get();

if ($bookStocks->isEmpty() || $users->isEmpty()) {
    echo "⚠️ Pastikan ada BookStock dan User (non-admin) terlebih dahulu!\n";
    exit;
}

$samplePeminjaman = [
    [
        'user_id' => $users[0]->id,
        'book_stock_id' => $bookStocks[0]->id,
        'kategori' => $bookStocks[0]->kategori,
        'judul_buku' => $bookStocks[0]->judul_buku,
        'tanggal_peminjaman' => now()->subDays(5),
        'tanggal_kembali_rencana' => now()->addDays(7),
        'status' => 'dipinjam',
        'catatan' => 'Peminjaman cepat untuk tugas sekolah',
    ],
];

// Add second sample if enough data
if ($bookStocks->count() >= 2 && $users->count() >= 2) {
    $samplePeminjaman[] = [
        'user_id' => $users[1]->id,
        'book_stock_id' => $bookStocks[1]->id,
        'kategori' => $bookStocks[1]->kategori,
        'judul_buku' => $bookStocks[1]->judul_buku,
        'tanggal_peminjaman' => now()->subDays(15),
        'tanggal_kembali_rencana' => now()->subDays(2),
        'tanggal_kembali_aktual' => now()->subDays(1),
        'status' => 'dikembalikan',
        'denda' => 10000,
        'catatan' => 'Terlambat 1 hari, denda Rp 10,000',
    ];
}

// Add third sample if enough data
if ($bookStocks->count() >= 3) {
    $samplePeminjaman[] = [
        'user_id' => $users[0]->id,
        'book_stock_id' => $bookStocks[2]->id,
        'kategori' => $bookStocks[2]->kategori,
        'judul_buku' => $bookStocks[2]->judul_buku,
        'tanggal_peminjaman' => now()->subDays(30),
        'tanggal_kembali_rencana' => now()->subDays(20),
        'status' => 'hilang',
        'catatan' => 'Buku hilang saat dibawa peminjam',
    ];
}

foreach ($samplePeminjaman as $data) {
    if (!PeminjamanBuku::where('user_id', $data['user_id'])
        ->where('judul_buku', $data['judul_buku'])
        ->where('tanggal_peminjaman', $data['tanggal_peminjaman'])
        ->exists()) {
        
        PeminjamanBuku::create($data);
        echo "✓ Peminjaman '{$data['judul_buku']}' oleh User {$data['user_id']} berhasil dibuat\n";
    }
}

echo "\n✅ Sample peminjaman created successfully!\n";

