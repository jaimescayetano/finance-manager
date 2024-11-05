<?php

namespace App\Services\Finance;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    const TABLE_NAME = 'users';

    public static function updateMoney(int $userId, float $amount, string $successMessage, string $type): array
    {
        if (!Schema::hasColumn(self::TABLE_NAME, $type)) {
            return [
                'status' => false,
                'message' => 'Invalid operation'
            ];
        }

        $newBalance = DB::transaction(function () use ($userId, $amount, $type) {
            $user = DB::table('users')->where('id', $userId)->lockForUpdate()->first();

            $current = round($user->$type, 2);
            $updated = round($current + $amount, 2);

            DB::table('users')->where('id', $userId)->update([$type => $updated]);

            return $updated;
        });

        return [
            'status' => true,
            'message' => $successMessage,
            'balance' => $newBalance,
        ];
    }
}
