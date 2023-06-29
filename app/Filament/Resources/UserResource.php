<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Forms\Components\Tabs;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $modelLabel = 'Mitarbeiter';
    protected static ?string $pluralModelLabel = 'Mitarbeiter';
    protected static ?string $navigationGroup = 'Administation';

    public static function form(Form $form): Form
    {

        return $form->schema(
            Tabs::make('Heading')
                ->tabs([
                    Tabs\Tab::make('Mitarbeiter')
                    ->columns(12)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                        ->label('Vor- und Nachname')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(6),
                    Forms\Components\TextInput::make('email')
                        ->label('E-Mail')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(6),
                    Forms\Components\TextInput::make('password')
                        ->label('Passwort')
                        ->password()
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(6)
                        ->confirmed(),
                    Forms\Components\TextInput::make('password_confirmation')
                        ->label('Passwort')
                        ->password()
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(6)
                    ]),
                ])
        );



    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Mitarbeiter'),
                Tables\Columns\TextColumn::make('email')
                ->label('E-Mail'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Erstellt am')
                    ->dateTime(),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
