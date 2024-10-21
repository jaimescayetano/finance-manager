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
                    'backgroundColor' => ' #74fe00',
                    'borderColor' => ' #74fe00',
                ],
                [
                    'label' => 'Registered expense',
                    'data' => Expense::getExpenseHistogramData(),
                    'backgroundColor' => '#c61af8',
                    'borderColor' => '#c61af8',
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
