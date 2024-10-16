<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\ActionTracking;
use App\Models\Expense;
use App\Models\Income;
use App\Observers\ExpenseObserver;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Filters\QueryBuilder;

class LatestTransactions extends BaseWidget
{
    protected static ?string $heading = 'Last actions';
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ActionTracking::query()
                    ->where('user_id', '=', auth()->id())
            )
            ->columns([
                TextColumn::make('amount')
                    ->icon('heroicon-o-currency-dollar'),
                TextColumn::make('message'),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        ExpenseObserver::CREATED_SUCESS_STATUS => 'Success',
                        ExpenseObserver::CREATED_WRONG_STATUS => 'Wrong',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        ExpenseObserver::CREATED_SUCESS_STATUS => 'success',
                        ExpenseObserver::CREATED_WRONG_STATUS => 'wrong',
                    }),
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        Expense::TYPE_ACTION => 'Expense',
                        Income::TYPE_ACTION => 'Income',
                    }),
                TextColumn::make('created_at')
                    ->icon('heroicon-s-calendar'),
            ]);
    }
}
