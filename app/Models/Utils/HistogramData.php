<?php

namespace App\Models\Utils;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait HistogramData
{
    public static function getHistogramData(string $table): array
    {
        if (!Schema::hasTable($table)) {
            error_log('Error in HistogramData.getHistogramData(), table not exists.');
            return [];
        }

        $data = DB::table($table)
            ->selectRaw("DATE_FORMAT(date, '%m') AS month, SUM(amount) AS total")
            ->whereRaw("date >= DATE_FORMAT(NOW(), '%Y-01-01')")
            ->where('user_id', '=', auth()->id())
            ->groupByRaw("DATE_FORMAT(date, '%m')")
            ->orderBy("month")
            ->get()
            ->toArray();
        
        $histogramData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach($data as $month) {
            $lastMonth = $month->month;
            $index = $lastMonth - 1;
            $value = $month->total;
            $histogramData[$index] = $value;
        }

        return array_slice($histogramData, 0, $lastMonth ?? 0);
    }
}