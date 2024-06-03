<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'month',
        'year',
        'homeOffice'
    ];

    public function users() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shift() : BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }
}
