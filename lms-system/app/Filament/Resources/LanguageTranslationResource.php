<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LanguageTranslationResource\Pages;
use App\Models\Language_Translation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LanguageTranslationResource extends Resource
{
    protected static ?string $model = Language_Translation::class;

    protected static ?string $navigationIcon = 'heroicon-o-language';
    
    protected static ?string $modelLabel = 'Language Translation';
    
    protected static ?string $navigationGroup = 'System Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('id_translation')
                    ->label('Indonesian Translation')
                    ->rows(3),
                Forms\Components\Textarea::make('en_translation')
                    ->label('English Translation')
                    ->rows(3),
                Forms\Components\TextInput::make('group')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable(),
                Tables\Columns\TextColumn::make('id_translation')
                    ->label('Indonesian Translation')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('en_translation')
                    ->label('English Translation')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('group')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->options(fn () => Language_Translation::distinct('group')->pluck('group', 'group')->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLanguageTranslations::route('/'),
            'create' => Pages\CreateLanguageTranslation::route('/create'),
            'edit' => Pages\EditLanguageTranslation::route('/{record}/edit'),
        ];
    }
}