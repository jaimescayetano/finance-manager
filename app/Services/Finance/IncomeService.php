<?php

namespace App\Services\Finance;

use App\Models\Income;

class IncomeService
{
    /**
     * Add up the amounts of all incomes incurred so far
     * @return float
     */
    public static function getTotalAmount(int $userId): float
    {
        $totalAmount = Income::selectRaw('SUM(amount) AS total_amount')
            ->where('user_id', '=', $userId)
            ->first()
            ->total_amount;

        return (float) $totalAmount;
    }
}
