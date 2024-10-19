<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'icon_svg', 'description', 'user_id', 'color'];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function reports(): BelongsToMany
    {
        return $this->belongsToMany(Report::class);
    }
}
