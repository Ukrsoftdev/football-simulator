<?php


namespace App\Services;


use App\Models\Game;
use App\Models\Team;
use App\Repositories\GameRepositoryInterface;
use App\Repositories\TeamRepositoryInterface;
use Illuminate\Support\Facades\DB;

class GameSimulateService implements GameSimulateServiceInterface
{

    /**
     * @param Game $game
     * @return Game
     */
    public function simulateGame(Game $game): Game
    {
        $game->home_team_goals = mt_rand(0, 5);
        while (true) {
            $awayGoals = mt_rand(0, 5);
            if ($game->home_team_goals != $awayGoals) {
                $game->away_team_goals = $awayGoals;
                break;
            }
        }
        return $game;
    }

    /**
     * @param Game $game
     * @return Game
     */
    public function scoreResult(Game $game):Game
    {
        if ($game->home_team_goals > $game->away_team_goals) {
            $game->home_team_score = 1;
            $game->away_team_score = 0;
        } else {
            $game->home_team_score = 0;
            $game->away_team_score = 1;
        }

        return $game;
    }
}
