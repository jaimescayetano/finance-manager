<?php

namespace App\Services\Finance;

use App\Models\Saving;
use App\Services\Finance\Utils\ITransaction;

class SavingsService implements ITransaction
{
    public static function read(): array
    {
        return [];
    }

    public static function create(): array
    {
        return [];
    }

    public static function update(): array
    {
        return [];
    }

    public static function delete(): array
    {
        return [];
    }

    /**
     * Add up the amounts of all savings incurred so far
     * @return float
     */
    public static function getTotalAmount(int $userId): float
    {
        $totalAmount = Saving::selectRaw('SUM(amount) AS total_amount')
            ->where('user_id', '=', $userId)
            ->first()
            ->total_amount;

        return (float) $totalAmount;
    }
}
