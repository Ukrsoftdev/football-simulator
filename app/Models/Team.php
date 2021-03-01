<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'division',
    ];

    public function gameHome()
    {
        return $this->hasMany(Game::class, 'home_team_id', 'id');
    }

    public function gameAway()
    {
        return $this->hasMany(Game::class, 'away_team_id', 'id');
    }
}
