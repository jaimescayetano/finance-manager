<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'type',
        'format',
        'start_date',
        'end_date',
        'user_id',
        'report_detail_id'
    ];


    public function reportDetail(): HasOne
    {
        return $this->hasOne(ReportDetail::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }    
}
