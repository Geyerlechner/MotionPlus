<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use App\Models\Orders;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\Widget;

class OrdersOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Abgewickelte Aufträge', Orders::where('completed', 1)->count()),
            Card::make('Offene Aufträge', Orders::where('completed', 0)->count()),
            Card::make('Gesamtumsatz', Orders::where('completed', '1')->sum('price').' €'),
            Card::make('Umsatz aus unfertigen Leistungen', Orders::where('completed', 0)->sum('price').' €'),
        ];
    }

}
