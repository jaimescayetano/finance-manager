<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\Expense;
use App\Models\Income;
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
                    'backgroundColor' => 'green',
                    'borderColor' => 'green',
                ],
                [
                    'label' => 'Registered expense',
                    'data' => Expense::getExpenseHistogramData(),
                    'backgroundColor' => 'red',
                    'borderColor' => 'red',
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
