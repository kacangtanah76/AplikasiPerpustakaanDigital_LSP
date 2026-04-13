<?php

namespace App\Filament\Admin\Resources\PeminjamanBukuResource\Pages;

use App\Filament\Admin\Resources\PeminjamanBukuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeminjamanBukus extends ListRecords
{
    protected static string $resource = PeminjamanBukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
