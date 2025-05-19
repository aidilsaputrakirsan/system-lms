<?php

namespace App\Filament\Resources\ImportExportLogResource\Pages;

use App\Filament\Resources\ImportExportLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditImportExportLog extends EditRecord
{
    protected static string $resource = ImportExportLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
