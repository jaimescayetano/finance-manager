<?php

namespace App\Services\Finance;

use App\Models\Income;
use App\Models\User;
use App\Services\Finance\Utils\ITransaction;
use Illuminate\Support\Facades\DB;

class IncomeService implements ITransaction
{
    const TABLE_NAME = 'incomes';

    public static function read(): array
    {
        return [];
    }

    public static function create(int $userId, array $data): array
    {
        $user = self::validateExistence('user', $userId);
        if (!$user) return ['success' => false, 'message' => __('messages.error.user_not_found')];

        if (!isset($data['amount']) || !is_numeric($data['amount']) || $data['amount'] <= 0) {
            return ['success' => false, 'message' => __('messages.errors.invalid_amount')];
        }

        return DB::transaction(function () use ($user, $data) {
            $amount = (float) $data['amount'];
            $newBalance = $user->balance + $amount;

            $income = Income::create($data);
            $user->update(['balance' => $newBalance]);

            return [
                'success' => true,
                'message' => __('messages.success.income_saved'),
                'model' => $income
            ];
        });
    }

    public static function update(int $userId, int $transactionId, array $data): array
    {
        $user = self::validateExistence('user', $userId);
        if (!$user) return ['success' => false, 'message' => __('messages.error.user_not_found')];

        $income = self::validateExistence('income', $transactionId, $userId);
        if (!$income) return ['success' => false, 'message' => __('messages.error.income_not_found')];

        if (!isset($data['amount']) || !is_numeric($data['amount']) || $data['amount'] < 0) {
            return ['success' => false, 'message' => __('messages.error.invalid_amount')];
        }

        return DB::transaction(function () use ($user, $income, $data) {
            $currentAmount = $income->amount;
            $newAmount = (float) $data['amount'];
            $difference = $newAmount - $currentAmount;
            $newBalance = $user->balance + $difference;

            $user->update(['balance' => $newBalance]);
            $income->update($data);

            return [
                'success' => true,
                'message' => __('messages.success.income_saved'),
                'model' => $income
            ];
        });
    }

    public static function delete(int $userId, int $transactionId): array
    {
        $user = self::validateExistence('user', $userId);
        if (!$user) return ['success' => false, 'message' => __('messages.error.user_not_found')];

        $income = self::validateExistence('income', $transactionId, $userId);
        if (!$income) return ['success' => false, 'message' => __('messages.error.income_not_found')];

        return DB::transaction(function () use ($user, $income) {
            $amount = (float) $income->amount;
            $newBalance = max(0, $user->balance - $amount);

            $user->update(['balance' => $newBalance]);
            $income->delete();

            return [
                'success' => true,
                'message' => __('messages.success.income_deleted')
            ];
        });
    }

    private static function validateExistence($type, $id, $userId = null)
    {
        if ($type === 'user') {
            return User::find($id);
        }

        if ($type === 'income') {
            return Income::where('id', $id)
                ->where('user_id', $userId)
                ->first();
        }

        return null;
    }

    public static function getTotalAmount(int $userId): float
    {
        $totalAmount = Income::selectRaw('SUM(amount) AS total_amount')
            ->where('user_id', '=', $userId)
            ->first()
            ->total_amount;

        return (float) $totalAmount;
    }
}
