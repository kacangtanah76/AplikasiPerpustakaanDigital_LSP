<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Book;
use App\Models\BookStock;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Sample data buku
$sample_books = [
    [
        'judul' => 'Laskar Pelangi',
        'author' => 'Andrea Hirata',
        'penerbit' => 'Bentang Pustaka',
        'tahun_rilis' => 2005,
        'kategori' => 'Fiksi',
        'stok_awal' => 10,
        'stok_saat_ini' => 10,
        'deskripsi' => 'Novel tentang para siswa MI Muhammadiyah Belitong yang berjuang keras untuk belajar.',
    ],
    [
        'judul' => 'Sang Pemimpi',
        'author' => 'Andrea Hirata',
        'penerbit' => 'Bentang Pustaka',
        'tahun_rilis' => 2006,
        'kategori' => 'Fiksi',
        'stok_awal' => 8,
        'stok_saat_ini' => 8,
        'deskripsi' => 'Lanjutan dari Laskar Pelangi yang menceritakan perjalanan Ikal ke Yogyakarta.',
    ],
    [
        'judul' => 'Negeri 5 Menara',
        'author' => 'Ahmad Fuadi',
        'penerbit' => 'Gramedia',
        'tahun_rilis' => 2012,
        'kategori' => 'Fiksi',
        'stok_awal' => 15,
        'stok_saat_ini' => 15,
        'deskripsi' => 'Novel tentang jalan menuju impian dan perjuangan seorang pemuda.',
    ],
    [
        'judul' => 'Filosofi Teras',
        'author' => 'Henry Manampiring',
        'penerbit' => 'Kompas',
        'tahun_rilis' => 2017,
        'kategori' => 'Non-Fiksi',
        'stok_awal' => 12,
        'stok_saat_ini' => 12,
        'deskripsi' => 'Buku yang menggabungkan filsafat Stoik dengan kehidupan modern di era digital.',
    ],
    [
        'judul' => 'Bumi Manusia',
        'author' => 'Pramoedya Ananta Toer',
        'penerbit' => 'Hasta Mitra',
        'tahun_rilis' => 1980,
        'kategori' => 'Fiksi Sejarah',
        'stok_awal' => 7,
        'stok_saat_ini' => 7,
        'deskripsi' => 'Novel pertama dari tetralogi Pulau Buru tentang gerakan nasional Indonesia.',
    ],
];

foreach ($sample_books as $data) {
    // Jangan duplikat
    if (!Book::where('judul', $data['judul'])->exists()) {
        $book = Book::create($data);
        
        // Buat stock record
        BookStock::create([
            'buku_id' => $book->id,
            'stok_awal' => $book->stok_awal,
            'stok_masuk' => 0,
            'stok_keluar' => 0,
            'stok_hilang' => 0,
            'stok_rusak' => 0,
            'stok_saat_ini' => $book->stok_saat_ini,
            'keterangan' => 'Initialized from sample data',
        ]);
        
        echo "✓ Buku '{$data['judul']}' berhasil ditambahkan\n";
    }
}

echo "\n✅ Sample books created successfully!\n";
