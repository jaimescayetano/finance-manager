<?php

namespace App\Services\Finance\Utils;

interface ITransaction
{
    public static function read(): array;

    public static function create(int $userId, array $data): array;

    public static function update(int $userId, int $transactionId, array $data): array;

    public static function delete(int $userId, int $transactionId): array;
}