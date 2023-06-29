<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\Tabs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $modelLabel = 'Ansprechperson';
    protected static ?string $pluralModelLabel = 'Ansprechpersonen';
    protected static ?string $navigationGroup = 'Kundenverwaltung';

    public static function form(Form $form): Form
    {


        return $form->schema(
            Tabs::make('Heading')
                ->tabs([
                    Tabs\Tab::make('Kundendaten')
                    ->columns(12)
                    ->schema([
                        Forms\Components\TextInput::make('firstname')
                        ->label('Vorname')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(6),
                    Forms\Components\TextInput::make('lastname')
                        ->label('Nachname')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(6),
                    Forms\Components\TextInput::make('email')
                        ->label('E-Mail Adresse')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(3),
                    Forms\Components\TextInput::make('phonenumber')
                        ->label('Telefonnummer')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(3),
                    Forms\Components\Select::make('customer_id')
                        ->required()
                        ->label('Kunde')
                        ->columnSpan(6)
                        ->relationship('customer', 'companyname'),
                    Forms\Components\Toggle::make('owner')
                        ->label('Geschäftsführer')
                        ->required(),


                    ]),
                ])
        );



    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('firstname')
                    ->label('Vorname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lastname')
                    ->label('Nachname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.companyname')
                    ->label('Firma')
                    ->searchable(),
                Tables\Columns\IconColumn::make('owner')
                    ->label('Geschäftsführer')
                    ->boolean(),
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
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
