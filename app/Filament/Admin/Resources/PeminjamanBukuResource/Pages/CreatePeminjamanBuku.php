<?php

namespace App\Filament\Admin\Resources\PeminjamanBukuResource\Pages;

use App\Filament\Admin\Resources\PeminjamanBukuResource;
use App\Models\BookStock;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePeminjamanBuku extends CreateRecord
{
    protected static string $resource = PeminjamanBukuResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Decrement stok saat buku dipinjam
        if (isset($data['book_stock_id']) && $data['book_stock_id']) {
            $stock = BookStock::find($data['book_stock_id']);
            if ($stock && $stock->stok_saat_ini > 0) {
                $stock->kurangiStokKeluar(1, 'Dipinjam');
            }
        }

        // Hitung denda jika sudah di-set tanggal kembalinya
        if (isset($data['tanggal_kembali_rencana']) && isset($data['status'])) {
            if ($data['status'] === 'dikembalikan' && isset($data['tanggal_kembali_aktual'])) {
                $rencana = \Carbon\Carbon::parse($data['tanggal_kembali_rencana']);
                $aktual = \Carbon\Carbon::parse($data['tanggal_kembali_aktual']);
                if ($aktual > $rencana) {
                    $hariTerlambat = $aktual->diffInDays($rencana);
                    $data['denda'] = $hariTerlambat * 10000;
                }
            }
        }

        return $data;
    }
}

