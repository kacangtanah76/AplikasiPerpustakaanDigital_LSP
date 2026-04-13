<?php

namespace App\Filament\Admin\Resources\StokBukuResource\Pages;

use App\Filament\Admin\Resources\StokBukuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStokBuku extends EditRecord
{
    protected static string $resource = StokBukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Calculate stok_saat_ini = stok_awal + stok_masuk - stok_keluar - stok_rusak - stok_hilang
        $data['stok_saat_ini'] = ($data['stok_awal'] ?? 0) 
                                 + ($data['stok_masuk'] ?? 0) 
                                 - ($data['stok_keluar'] ?? 0) 
                                 - ($data['stok_rusak'] ?? 0) 
                                 - ($data['stok_hilang'] ?? 0);
        
        return $data;
    }
}

