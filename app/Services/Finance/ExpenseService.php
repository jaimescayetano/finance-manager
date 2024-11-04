<?php

namespace App\Services\Finance;

use App\Models\Expense;

class ExpenseService
{
    /**
     * Add up the amounts of all expenses incurred so far
     * @return float
     */
    public static function getTotalAmount(int $userId): float
    {
        $totalAmount = Expense::selectRaw('SUM(amount) AS total_amount')
            ->where('user_id', '=', $userId)
            ->first()
            ->total_amount;
            
        return (float) $totalAmount;
    }
}
