<?php

namespace App\Models\Utils;

use App\Models\Expense;
use App\Models\Income;

trait StatisticalData
{
    public static function getPercentaje(string $type): float
    {
        $incomesCurrentMonth = self::getCurrentAmount(Income::TYPE_ACTION);
        $expensesCurrentMonth = self::getCurrentAmount(Expense::TYPE_ACTION);

        if ($incomesCurrentMonth <= 0) return 0;

        if ($type === Expense::TYPE_ACTION) {
            return round($expensesCurrentMonth * 100 / $incomesCurrentMonth, 2);
        }

        if ($type === Income::TYPE_ACTION) {
            return round(($incomesCurrentMonth - $expensesCurrentMonth) * 100 / $incomesCurrentMonth, 2);
        }

        return 0;
    }

    public static function getCurrentAmount(string $type, int $month = null): float
    {
        # ToDo: I think it is possible to apply the strategy pattern
        switch ($type) {
            case Expense::TYPE_ACTION:
                $query = Expense::selectRaw('SUM(amount) AS amount');
                break;
            case Income::TYPE_ACTION:
                $query = Income::selectRaw('SUM(amount) AS amount');
                break;
            default:
                break;
        }

        if (!isset($query)) return 0;

        $query = $query->whereRaw('MONTH(date) = MONTH(NOW())')
            ->first()
            ->toArray();

        return $query['amount'] ?? 0;
    }

    public static function getDataPerMonth(string $type): array
    {
        switch ($type) {
            case Expense::TYPE_ACTION:
                $query = Expense::selectRaw('SUM(amount) AS amount');
                break;
            case Income::TYPE_ACTION:
                $query = Income::selectRaw('SUM(amount) AS amount');
                break;
            default:
                break;
        }

        $data = $query->groupByRaw('MONTH(date)')
            ->whereRaw('YEAR(date) = YEAR(NOW()) AND MONTH(date) <= MONTH(NOW())')
            ->orderByRaw('MONTH(date) ASC')
            ->get()
            ->pluck('amount')
            ->toArray();

        if (count($data) <= 1) {
            array_unshift($data, 0);
        }

        return $data;
    }
}
