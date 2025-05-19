<?php

namespace App\Filament\Resources\ImportExportLogResource\Pages;

use App\Filament\Resources\ImportExportLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListImportExportLogs extends ListRecords
{
    protected static string $resource = ImportExportLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
