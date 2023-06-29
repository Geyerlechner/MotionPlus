<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages;
use App\Filament\Resources\MediaResource\RelationManagers;
use App\Models\Media;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $modelLabel = 'Dokument';
    protected static ?string $pluralModelLabel = 'Dokumente';
    protected static ?string $navigationGroup = 'Kundenverwaltung';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('model_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('model_id')
                    ->required(),
                Forms\Components\TextInput::make('uuid')
                    ->maxLength(36),
                Forms\Components\TextInput::make('collection_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('file_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('mime_type')
                    ->maxLength(255),
                Forms\Components\TextInput::make('disk')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('conversions_disk')
                    ->maxLength(255),
                Forms\Components\TextInput::make('size')
                    ->required(),
                Forms\Components\Textarea::make('manipulations')
                    ->required(),
                Forms\Components\Textarea::make('custom_properties')
                    ->required(),
                Forms\Components\Textarea::make('generated_conversions')
                    ->required(),
                Forms\Components\Textarea::make('responsive_images')
                    ->required(),
                Forms\Components\TextInput::make('order_column'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('model_id'),
                Tables\Columns\TextColumn::make('collection_name')
                    ->label('Colletion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Dateiname')
                    ->searchable(),

                Tables\Columns\TextColumn::make('mime_type'),
                Tables\Columns\TextColumn::make('disk')
                    ->label('Speicher'),

                Tables\Columns\TextColumn::make('size')
                    ->label('Dateigröße'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Erstellt am')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
