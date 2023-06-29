<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use App\Models\Customer;
use App\Models\Orders;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class CustomerOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Kunden gesamt', Customer::all()->count()),
            Card::make('Kunden deaktiviert', Customer::where('status', 'Blockierend')->count()),
        ];
    }
}
