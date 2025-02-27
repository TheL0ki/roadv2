<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'displayName'
    ];

    public function user() : HasMany
    {
        return $this->hasMany(User::class);
    }

    public function manager() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function shift() : BelongsToMany
    {
        return $this->belongsToMany(Shift::class);
    }
}
