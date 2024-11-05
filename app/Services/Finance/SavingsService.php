<?php

namespace App\Services\Finance;

use App\Models\Saving;
use App\Models\User;
use App\Services\Finance\Utils\ITransaction;

class SavingsService implements ITransaction
{
    const TABLE_NAME = 'savings';

    public static function read(): array
    {
        return [];
    }

    public static function create(int $userId, float $amount): array
    {
        $expenseResponse = User::applyExpense($amount);
        if (!$expenseResponse['status']) return $expenseResponse;

        return TransactionService::updateMoney(
            $userId,
            $amount,
            __('messages.success.savings_updated'),
            self::TABLE_NAME
        );
    }

    public static function update(int $userId, int $transactionId, array $data): array
    {
        return [];
    }

    public static function delete(int $userId, int $transactionId): array
    {
        $saving = Saving::find($transactionId);
        $amount = $saving->amount;

        $balanceResponse = TransactionService::updateMoney(
            $userId,
            $amount,
            __('messages.success.balance'),
            'balance'
        );

        if (!$balanceResponse['status']) return $balanceResponse;

        $saving->delete();

        return TransactionService::updateMoney(
            $userId,
            -$amount,
            __('messages.success.savings_deleted'),
            self::TABLE_NAME
        );
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
