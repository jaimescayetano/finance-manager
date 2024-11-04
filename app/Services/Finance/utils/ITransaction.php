<?php

namespace App\Services\Finance\Utils;

interface ITransaction
{
    public static function read(): array;

    public static function create(): array;

    public static function update(): array;

    public static function delete(): array;
}