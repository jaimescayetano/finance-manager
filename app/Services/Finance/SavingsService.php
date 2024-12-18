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

    public static function create(int $userId, array $data): array
    {
        $userValidation = self::checkUserExistence($userId);
        if (!$userValidation['exists']) return ['success' => false, 'message' => $userValidation['message']];

        $user = $userValidation['model'];

        $currentBalance = $user->balance;
        $currentSavings = $user->savings;
        $amount = $data['amount'];
        $newBalance = $currentBalance - $amount;
        $newSavings = $currentSavings + $amount;

        $saving = Saving::create($data);
        $user->update(['balance' => $newBalance, 'savings' => $newSavings]);

        return [
            'success' => true,
            'message' => __('messages.success.savings_saved'),
            'model' => $saving
        ];
    }

    public static function update(int $userId, int $transactionId, array $data): array
    {
        $userValidation = self::checkUserExistence($userId);
        if (!$userValidation['exists']) return ['success' => false, 'message' => $userValidation['message']];

        $savingValidation = self::checkSavingExistence($transactionId, $userId);
        if (!$savingValidation['exists']) return ['success' => false, 'message' => $savingValidation['message']];

        $user = $userValidation['model'];
        $saving = $savingValidation['model'];

        $currentSaving = Saving::where('id', '=', $transactionId)
            ->where('user_id', '=', $userId)
            ->first();

        $currentAmount = $saving->amount;
        $newAmount = $data['amount'];
        $difference = $currentAmount - $newAmount;
        $currentBalance = $user->balance;
        $currentSavings = $user->savings;
        $newBalance = $currentBalance + $difference;
        $newSavings = $currentSavings - $difference;

        if ($newBalance < 0) {
            return [
                'success' => false,
                'message' => __('messages.errors.insufficient_balance')
            ];
        }

        $user->update(['balance' => $newBalance, 'savings' => $newSavings]);
        $currentSaving->update($data);

        return [
            'success' => true,
            'message' => __('messages.success.savings_updated'),
            'model' => $currentSaving
        ];
    }

    public static function delete(int $userId, int $transactionId): array
    {
        $userValidation = self::checkUserExistence($userId);
        if (!$userValidation['exists']) return ['success' => false, 'message' => $userValidation['message']];

        $savingValidation = self::checkSavingExistence($transactionId, $userId);
        if (!$savingValidation['exists']) return ['success' => false, 'message' => $savingValidation['message']];

        $user = $userValidation['model'];
        $saving = $savingValidation['model'];

        $amount = (float) $saving->amount;
        $currentBalance = $user->balance;
        $currentSavings = $user->savings;
        $newBalance = $currentBalance + $amount;
        $newSavings = $currentSavings - $amount;

        $user->update(['balance' => $newBalance, 'savings' => $newSavings]);
        $saving->delete();

        return [
            'success' => true,
            'message' => __('messages.success.savings_deleted')
        ];
    }

    public static function getTotalAmount(int $userId): float
    {
        $totalAmount = Saving::selectRaw('SUM(amount) AS total_amount')
            ->where('user_id', '=', $userId)
            ->first()
            ->total_amount;

        return (float) $totalAmount;
    }

    public static function checkSavingExistence(int $savingId, int $userId): array
    {
        $saving = Saving::where('id', '=', $savingId)
            ->where('user_id', '=', $userId)
            ->first();

        return [
            'exists' => $saving ? true : false,
            'message' => $saving ? __('messages.success.savings_found') : __('messages.errors.saving_not_found'),
            'model' => $saving ?? null
        ];
    }

    public static function checkUserExistence(int $userId): array
    {
        $user = User::find($userId);
        return [
            'exists' => $user ? true : false,
            'message' => $user ? __('messages.success.user_found') : __('messages.errors.user_not_found'),
            'model' => $user ?? null
        ];
    }
}
