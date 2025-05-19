<?php

namespace App\Filament\Resources\LanguageTranslationResource\Pages;

use App\Filament\Resources\LanguageTranslationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLanguageTranslation extends EditRecord
{
    protected static string $resource = LanguageTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
