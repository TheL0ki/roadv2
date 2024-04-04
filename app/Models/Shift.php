<?php

namespace App\Models;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display',
        'color',
        'textColor',
        'hours',
        'active'
    ];

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }
}
