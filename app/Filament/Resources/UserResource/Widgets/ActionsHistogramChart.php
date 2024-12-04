<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Saving;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ActionsHistogramChart extends ChartWidget
{
    protected static ?string $heading = 'Expense/Income';
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Registered income',
                    'data' => Income::getIncomeHistogramData(),
                    'backgroundColor' => '#72f205',
                    'borderColor' => '#72f205',
                ],
                [
                    'label' => 'Registered expense',
                    'data' => Expense::getExpenseHistogramData(),
                    'backgroundColor' => '#f9321a',
                    'borderColor' => '#f9321a',
                ],
                [
                    'label' => 'Registered savings',
                    'data' => Saving::getSavingHistogramData(),
                    'backgroundColor' => '#0CB7F2',
                    'borderColor' => '#0CB7F2',
                ]
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
