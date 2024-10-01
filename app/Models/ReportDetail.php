<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'initial_amount',
        'final_amount',
        'metadata'
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
