<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookStock;
use Illuminate\Database\Seeder;

class BookStockSeeder extends Seeder
{
    public function run(): void
    {
        // Get semua buku dan buat stock record untuk masing-masing
        $books = Book::all();

        foreach ($books as $book) {
            // Cek apakah sudah ada stock record
            if (!BookStock::where('buku_id', $book->id)->exists()) {
                BookStock::create([
                    'buku_id' => $book->id,
                    'stok_awal' => $book->stok_awal,
                    'stok_masuk' => 0,
                    'stok_keluar' => 0,
                    'stok_hilang' => 0,
                    'stok_rusak' => 0,
                    'stok_saat_ini' => $book->stok_saat_ini,
                    'keterangan' => 'Stock initialized from books table',
                ]);
            }
        }

        $this->command->info('BookStock seeder completed successfully!');
    }
}

