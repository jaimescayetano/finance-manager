<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
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
            Stat::make('Expenses', Expense::getPercentaje(Expense::TYPE_ACTION) . '%')
                ->description('7% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Incomes', Income::getPercentaje(Income::TYPE_ACTION) . '%')
                ->description('3% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Savings', auth()->user()->savings ?? 0)
                ->description('Saved')
                ->descriptionIcon('heroicon-o-star')
                ->color('primary'),
        ];
    }
}
