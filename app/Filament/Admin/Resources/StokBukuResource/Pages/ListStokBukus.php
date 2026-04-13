<?php

namespace App\Filament\Admin\Resources\StokBukuResource\Pages;

use App\Filament\Admin\Resources\StokBukuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStokBukus extends ListRecords
{
    protected static string $resource = StokBukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
