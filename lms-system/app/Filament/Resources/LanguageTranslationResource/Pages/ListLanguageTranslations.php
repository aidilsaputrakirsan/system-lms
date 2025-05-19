<?php

namespace App\Filament\Resources\LanguageTranslationResource\Pages;

use App\Filament\Resources\LanguageTranslationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLanguageTranslations extends ListRecords
{
    protected static string $resource = LanguageTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
