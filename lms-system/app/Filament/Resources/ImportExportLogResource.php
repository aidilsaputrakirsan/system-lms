<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImportExportLogResource\Pages;
use App\Models\Import_Export_Log;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ImportExportLogResource extends Resource
{
    protected static ?string $model = Import_Export_Log::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    
    protected static ?string $modelLabel = 'Import/Export Log';
    
    protected static ?string $navigationGroup = 'System Tools';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\FileUpload::make('file_path')
                    ->label('Log File')
                    ->directory('import-export-logs'),
                Forms\Components\Select::make('operation_type')
                    ->options([
                        'import' => 'Import',
                        'export' => 'Export',
                    ])
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('result_message')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('records_processed')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('records_success')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('records_failed')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('operation_type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'processing' => 'warning',
                        'completed' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('records_processed')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('records_success')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('records_failed')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('operation_type')
                    ->options([
                        'import' => 'Import',
                        'export' => 'Export',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                    ]),
            ])
            ->actions([
            //    Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListImportExportLogs::route('/'),
         //   'view' => Pages\ViewImportExportLog::route('/{record}'),
        ];
    }
}