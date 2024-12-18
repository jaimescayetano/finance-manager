<?php

namespace App\Models;

use App\Models\Utils\HistogramData;
use App\Models\Utils\StatisticalData;
use App\Observers\ExpenseObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Facades\DB;

#[ObservedBy([ExpenseObserver::class])]
class Expense extends Model
{
    use HasFactory;
    use HistogramData;
    use StatisticalData;

    const TABLE_NAME = 'expenses';
    const TYPE_ACTION = 'E';
    const TYPE_PROGRAMMED = 'P';
    const TYPE_REGULAR = 'R';

    protected $fillable = [
        'title',
        'amount',
        'description',
        'date',
        'type',
        'category_id',
        'user_id',
    ];

    public static function getExpenseHistogramData(): array
    {
        return self::getHistogramData(self::TABLE_NAME);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
