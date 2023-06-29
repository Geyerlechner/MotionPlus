<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdersResource\Pages;
use App\Filament\Resources\OrdersResource\RelationManagers;
use App\Models\Orders;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\BadgeColumn;

class OrdersResource extends Resource
{
    protected static ?string $model = Orders::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'Autfrag';
    protected static ?string $pluralModelLabel = 'Auftäge';
    protected static ?string $navigationGroup = 'Kundenverwaltung';

    public static function form(Form $form): Form
    {
        return $form->schema(
            Tabs::make('Heading')
                ->tabs([
                    Tabs\Tab::make('Neuer Auftrag')
                    ->columns(12)
                    ->schema([
                    Forms\Components\TextInput::make('order')
                        ->label('Auftragsbezeichnung')
                        ->required()
                        ->columnSpan(12),
                    Forms\Components\DatePicker::make('deadline')
                        ->label('Abgabefrist')
                        ->required()
                        ->columnSpan(6),
                    Forms\Components\Select::make('customer_id')
                        ->required()
                        ->label('Kunde')
                        ->columnSpan(6)
                        ->relationship('customer', 'companyname'),
                    Forms\Components\TextInput::make('price')
                        ->label('Kosten €   ')
                        ->numeric()
                        ->columnSpan(3),
                    Forms\Components\Select::make('priority')
                            ->label('Priorität')
                            ->options([
                                'Hohe Priorität' => 'Hohe Priorität',
                                'Mittlere Priorität' => 'Mittlere Priorität',
                                'Niedrige Priorität' => 'Niedrige Priorität',
                                'Blockierend' => 'Blockierend',
                            ])
                            ->required()
                            ->columnSpan(3),
                    Forms\Components\TextInput::make('estimated_effort')
                        ->label('Geschätzte Aufwand (in Tage)')
                        ->numeric()
                        ->columnSpan(3)
                        ->required(),
                    Forms\Components\TextInput::make('actual_expense')
                        ->label('Tatsächlicher Aufwand (in Tage)')
                        ->numeric()
                        ->columnSpan(3)
                        ->required(),
                    Forms\Components\RichEditor::make('description')
                        ->label('Beschreibung')
                        ->columnSpan(12)
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Toggle::make('completed')
                        ->label('Fertiggestellt')
                        ->columnSpan(1)
                    ]),
                    Tabs\Tab::make('Dokumentation')->schema([
                        Forms\Components\RichEditor::make('documentation')
                            ->label('Dokumentation')
                            ->columnSpan(12)
                            ->maxLength(255),
                    ]),
                    Tabs\Tab::make('Dokumente')->schema([
                        SpatieMediaLibraryFileUpload::make('Dokumente')
                        ->collection('documents')
                        ->enableReordering()
                        ->multiple(),
                    ])
                ])
        );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('order')
                ->searchable()
                ->label('Auftragsbezeichnung'),
            Tables\Columns\TextColumn::make('customer.companyname')
                ->label('Firma'),
            Tables\Columns\BadgeColumn::make('priority')
                    ->label('Priorität')
                    ->colors([
                        'primary',
                        'secondary' => 'Niedrige Priorität',
                        'warning'   => 'Mittlere Priorität',
                        'success'   => 'Hohe Priorität',
                        'danger'    => 'Blockierend',
                    ]),
            Tables\Columns\TextColumn::make('deadline')
                ->label('Abgabefrist')
                ->since(),
                Tables\Columns\IconColumn::make('completed')
                ->label('Fertiggestellt')
                ->boolean(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Erstellt am')
                ->since(),
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
            \app\Filament\Resources\CustomerResource\Widgets\OrdersOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrders::route('/create'),
            'edit' => Pages\EditOrders::route('/{record}/edit'),
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
