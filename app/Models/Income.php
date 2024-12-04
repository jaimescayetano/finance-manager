<?php

namespace App\Models;

use App\Models\Utils\HistogramData;
use App\Models\Utils\StatisticalData;
use App\Observers\IncomeObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([IncomeObserver::class])]
class Income extends Model
{
    use HasFactory;
    use HistogramData;
    use StatisticalData;

    const TABLE_NAME = 'incomes';
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
        return self::getHistogramData(self::TABLE_NAME);
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
