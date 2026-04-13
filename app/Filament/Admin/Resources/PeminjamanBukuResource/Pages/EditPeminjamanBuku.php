<?php

namespace App\Filament\Admin\Resources\PeminjamanBukuResource\Pages;

use App\Filament\Admin\Resources\PeminjamanBukuResource;
use App\Models\BookStock;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeminjamanBuku extends EditRecord
{
    protected static string $resource = PeminjamanBukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Handle status change effects
        if ($this->record->status === 'dipinjam' && $data['status'] === 'dikembalikan') {
            // Increment stok saat buku dikembalikan
            if ($this->record->book_stock_id) {
                $stock = BookStock::find($this->record->book_stock_id);
                if ($stock) {
                    $stock->tambahStokMasuk(1, 'Buku dikembalikan');
                }
            }

            // Set tanggal kembali aktual
            $data['tanggal_kembali_aktual'] = now();

            // Calculate denda
            if (isset($data['tanggal_kembali_rencana'])) {
                $rencana = \Carbon\Carbon::parse($data['tanggal_kembali_rencana']);
                $aktual = now();
                if ($aktual > $rencana) {
                    $hariTerlambat = $aktual->diffInDays($rencana);
                    $data['denda'] = $hariTerlambat * 10000;
                }
            }
        }

        // Handle dari dipinjam ke hilang
        if ($this->record->status === 'dipinjam' && $data['status'] === 'hilang') {
            if ($this->record->book_stock_id) {
                $stock = BookStock::find($this->record->book_stock_id);
                if ($stock) {
                    $stock->catatStokHilang(1, 'Hilang saat peminjaman');
                }
            }
        }

        return $data;
    }
}

