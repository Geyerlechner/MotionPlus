<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\Tabs;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $modelLabel = 'Kunde';
    protected static ?string $pluralModelLabel = 'Kunden';
    protected static ?string $navigationGroup = 'Kundenverwaltung';

    public static function form(Form $form): Form
    {
        return $form->schema(
            Tabs::make('Heading')
                ->tabs([
                    Tabs\Tab::make('Kundendaten')
                    ->columns(12)
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('E-Mail')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(6),
                        Forms\Components\TextInput::make('companyname')
                            ->label('Firma')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(6),
                        Forms\Components\TextInput::make('phonenumber')
                            ->label('Telefonnummer')
                            ->tel()
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(3),
                        Forms\Components\TextInput::make('website')
                            ->label('Webseite')
                            ->url()
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(4),
                        Forms\Components\Select::make('status')
                            ->label('Priorität')
                            ->options([
                                'Hohe Priorität' => 'Hohe Priorität',
                                'Mittlere Priorität' => 'Mittlere Priorität',
                                'Niedrige Priorität' => 'Niedrige Priorität',
                                'Blockierend' => 'Blockierend',
                            ])
                            ->required()
                            ->columnSpan(4),
                        Forms\Components\TextInput::make('address')
                            ->label('Adresse')
                            ->maxLength(65535)
                            ->columnSpan(12),
                            ]),
                    Tabs\Tab::make('Kundeninformationen')->schema([
                        Forms\Components\RichEditor::make('description')
                        ->label('Kundeninformationen')
                        ->maxLength(65535)
                        ->columnSpan(12),
                    Tabs\Tab::make('Dokumente')->schema([])
                    ])
                ])
        );

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->label('E-Mail'),
                Tables\Columns\TextColumn::make('companyname')
                    ->searchable()
                    ->label('Firma'),
                Tables\Columns\TextColumn::make('phonenumber')
                    ->label('Telefonnummer'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'primary',
                        'secondary' => 'Niedrige Priorität',
                        'warning'   => 'Mittlere Priorität',
                        'success'   => 'Hohe Priorität',
                        'danger'    => 'Blockierend',
                ]),
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

    public static function getWidgets() : array
    {
       return [
        \app\Filament\Resources\CustomerResource\Widgets\CustomerOverview::class,
       ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
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
