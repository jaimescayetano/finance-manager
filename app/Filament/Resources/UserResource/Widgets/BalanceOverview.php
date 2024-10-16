<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BalanceOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Balance', auth()->user()->balance)
                ->description('Available balance')
                ->descriptionIcon('heroicon-o-currency-dollar')
                //->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Expenses', '21%')
                ->description('7% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Incomes', '3:12')
                ->description('3% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Savings', '3:12')
                ->description('3% increase')
                ->descriptionIcon('heroicon-o-star')
                ->color('primary'),
        ];
    }
}
