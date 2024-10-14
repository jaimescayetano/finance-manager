<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActionTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'amount',
        'status',
        'type',
        'user_id'
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
