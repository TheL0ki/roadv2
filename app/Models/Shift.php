<?php

namespace App\Models;

use App\Models\Team;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display',
        'color',
        'textColor',
        'hours',
        'active',
        'flexLoc',
        'override'
    ];

    public function schedules() : HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function team(int $id) : void
    {
        $team = Team::find($id);
        
        $this->teams()->attach($team);
    }

    public function teams() : BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }
}
