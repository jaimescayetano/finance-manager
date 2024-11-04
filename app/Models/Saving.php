<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Utils\HistogramData;
use App\Observers\SavingsObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([SavingsObserver::class])]
class Saving extends Model
{
    use HasFactory;
    use HistogramData;

    const TABLE_NAME = 'savings';
    const TYPE_ACTION = 'S';

    protected $fillable = [
        'title',
        'amount',
        'user_id'
    ];

    public static function getSavingHistogramData(): array
    {
        return self::getHistogramData(self::TABLE_NAME);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
