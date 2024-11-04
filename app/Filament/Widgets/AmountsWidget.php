<?php

namespace App\Filament\Widgets;

use App\Services\Finance\ExpenseService;
use App\Services\Finance\IncomeService;
use App\Services\Finance\SavingsService;
use Filament\Widgets\Widget;

class AmountsWidget extends Widget
{
    protected int | string | array $columnSpan = 1;
    protected static ?int $sort = 3;
    protected static string $view = 'filament.widgets.amounts-widget';

    public float $savings;
    public float $expenses;
    public float $incomes;
    public string $prefix = 'S/.';
    public string $startDate;

    public function mount()
    {
        $user = auth()->user();
        $userId = $user->id;

        $this->savings = SavingsService::getTotalAmount($userId);
        $this->expenses = ExpenseService::getTotalAmount($userId);
        $this->incomes = IncomeService::getTotalAmount($userId);
        
        $this->startDate = $user->created_at->format('d-m-Y');
    }
}
