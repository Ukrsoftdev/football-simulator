<?php


namespace App\Repositories;


use App\Models\Game;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeamRepository implements TeamRepositoryInterface
{
    public function getAllTeamsByDivision()
    {
        return Team::all()->groupBy('division')->collect();
    }

    public function getAllTeamsWithScoreByDivision()
    {
        return Team::with(['gameHome', 'gameAway'])->get()->map(function ($team) {
            return $this->calculateScores($team);
        })->groupBy('division')->collect();
    }

    /**
     * @param Team $team
     * @return Team
     */
    private function calculateScores(Team $team): Team
    {
        $scoreSeason = 0;
        $scorePlayoff = 0;

        //Calculate Home Game
        foreach ($team->gameHome as $game) {
            if ($game->category === env('CATEGORY_GAME_SEASON'))
                $scoreSeason += $game->home_team_score;
            if ($game->category === env('CATEGORY_GAME_PLAYOFF'))
                $scorePlayoff += $game->home_team_score;
        }

        //Calculate Away Game
        foreach ($team->gameAway as $game) {
            if ($game->category === env('CATEGORY_GAME_SEASON'))
                $scoreSeason += $game->away_team_score;
            if ($game->category === env('CATEGORY_GAME_PLAYOFF'))
                $scorePlayoff += $game->away_team_score;
        }

        $team->scoreSeason = $scoreSeason;
        $team->scorePlayoff = $scorePlayoff;
        unset($team->gameHome, $team->gameAway);

        return $team;
    }
}
