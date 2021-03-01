<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';
    public $timestamps = false;

    public static $jsonType = 'game';

    protected $fillable = [
        'category',
        'home_team_id',
        'away_team_id',
        'home_team_goals',
        'away_team_goals',
        'home_team_score',
        'away_team_score',
    ];

}
