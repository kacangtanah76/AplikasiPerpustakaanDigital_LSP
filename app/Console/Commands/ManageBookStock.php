<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\BookStock;
use Illuminate\Console\Command;

class ManageBookStock extends Command
{
    protected $signature = 'stock:manage {action} {book_id?} {quantity?}';

    protected $description = 'Manage book stock - Actions: list, add, remove, damage, lost';

    public function handle()
    {
        $action = $this->argument('action');
        
        match($action) {
            'list' => $this->listStocks(),
            'add' => $this->addStock(),
            'remove' => $this->removeStock(),
            'damage' => $this->damageStock(),
            'lost' => $this->lostStock(),
            default => $this->error("Action '{$action}' tidak dikenali")
        };
    }

    private function listStocks()
    {
        $stocks = BookStock::all();
        
        $table_data = $stocks->map(function ($stock) {
            return [
                $stock->id,
                $stock->judul_buku ?? 'N/A',
                $stock->stok_awal,
                $stock->stok_saat_ini,
                $stock->stok_masuk,
                $stock->stok_keluar,
                $stock->stok_rusak,
                $stock->stok_hilang,
                $stock->getStatusStok(),
                $stock->getPersentaseStok() . '%',
            ];
        });

        $this->table(
            ['ID', 'Judul Buku', 'Stok Awal', 'Stok Saat Ini', 'Masuk', 'Keluar', 'Rusak', 'Hilang', 'Status', '%'],
            $table_data
        );
    }

    private function addStock()
    {
        $book_id = $this->argument('book_id');
        $quantity = $this->argument('quantity');

        if (!$book_id || !$quantity) {
            $this->error('Usage: php artisan stock:manage add <book_id> <quantity>');
            return;
        }

        $stock = BookStock::where('buku_id', $book_id)->first();
        if (!$stock) {
            $this->error("Stok buku dengan ID {$book_id} tidak ditemukan");
            return;
        }

        $keterangan = $this->ask('Keterangan (opsional)');
        $stock->tambahStokMasuk($quantity, $keterangan);

        $this->info("✓ Stok berhasil ditambah. Stok saat ini: {$stock->stok_saat_ini}");
    }

    private function removeStock()
    {
        $book_id = $this->argument('book_id');
        $quantity = $this->argument('quantity');

        if (!$book_id || !$quantity) {
            $this->error('Usage: php artisan stock:manage remove <book_id> <quantity>');
            return;
        }

        $stock = BookStock::where('buku_id', $book_id)->first();
        if (!$stock) {
            $this->error("Stok buku dengan ID {$book_id} tidak ditemukan");
            return;
        }

        try {
            $keterangan = $this->ask('Keterangan (opsional)');
            $stock->kurangiStokKeluar($quantity, $keterangan);
            $this->info("✓ Stok berhasil dikurangi. Stok saat ini: {$stock->stok_saat_ini}");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    private function damageStock()
    {
        $book_id = $this->argument('book_id');
        $quantity = $this->argument('quantity');

        if (!$book_id || !$quantity) {
            $this->error('Usage: php artisan stock:manage damage <book_id> <quantity>');
            return;
        }

        $stock = BookStock::where('buku_id', $book_id)->first();
        if (!$stock) {
            $this->error("Stok buku dengan ID {$book_id} tidak ditemukan");
            return;
        }

        try {
            $keterangan = $this->ask('Keterangan kerusakan (opsional)');
            $stock->catatStokRusak($quantity, $keterangan);
            $this->info("✓ Kerusakan berhasil dicatat. Stok saat ini: {$stock->stok_saat_ini}");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    private function lostStock()
    {
        $book_id = $this->argument('book_id');
        $quantity = $this->argument('quantity');

        if (!$book_id || !$quantity) {
            $this->error('Usage: php artisan stock:manage lost <book_id> <quantity>');
            return;
        }

        $stock = BookStock::where('buku_id', $book_id)->first();
        if (!$stock) {
            $this->error("Stok buku dengan ID {$book_id} tidak ditemukan");
            return;
        }

        try {
            $keterangan = $this->ask('Keterangan kehilangan (opsional)');
            $stock->catatStokHilang($quantity, $keterangan);
            $this->info("✓ Kehilangan berhasil dicatat. Stok saat ini: {$stock->stok_saat_ini}");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}

