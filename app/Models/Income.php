<?php

namespace App\Models;

use App\Models\Utils\HistogramData;
use App\Models\Utils\StatisticalData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Income extends Model
{
    use HasFactory;
    use HistogramData;
    use StatisticalData;

    const TYPE_ACTION = 'I';

    protected $fillable = [
        'amount',
        'description',
        'date',
        'income_source_id',
        'user_id',
    ];

    # Todo: Create an entity in charge of generating statistical data
    public static function getIncomeHistogramData(): array
    {
        return self::getHistogramData('incomes');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function incomeSource()
    {
        return $this->belongsTo(IncomeSource::class);
    }
}
