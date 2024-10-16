<?php

namespace App\Filament\Resources\CategoryResource\Widgets;

use App\Models\Category;
use App\Models\Expense;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ExpensiveByCategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Expenses by category';

    public function getDescription(): ?string
    {
        return 'Shows cats by category for the last month.';
    }

    protected function getData(): array
    {
        $expenses = Expense::select(
            'categories.title',
            'categories.color',
            DB::raw('SUM(expenses.amount) AS total')
        )
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->where('expenses.user_id', '=', auth()->id())
            ->groupBy('expenses.category_id', 'categories.title', 'categories.color')
            ->get();

        $labels = [];
        $totals = [];
        $colors = [];

        foreach ($expenses as $expense) {
            $labels[] = $expense->title;
            $totals[] = $expense->total;
            $colors[] = $expense->color;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $totals,
                    'backgroundColor' => $colors,
                    'borderColor' => $colors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
