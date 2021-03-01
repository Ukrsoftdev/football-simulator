<?php


namespace App\Repositories;


use App\Models\Game;
use App\Models\Team;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GameRepository implements GameRepositoryInterface
{
    /**
     * @var Team
     */
    private $team;

    /**
     * @var Game
     */
    private $game;

    public function __construct(Team $team, Game $game)
    {
        $this->team = $team;
        $this->game = $game;
    }

    public function getAllGamesForStandings()
    {
        return Game::all();
    }

    public function clearAllGames()
    {
        DB::table((new Game())->getTable())->truncate();
    }

    public function clearPlayoffGames()
    {
        return Game::destroy(Game::where('category', env('CATEGORY_GAME_PLAYOFF'))->get('id')->toArray());
    }

    public function getSeasonGames()
    {
        return Game::where('category', env('CATEGORY_GAME_SEASON'))->get();
    }

    public function getPlayoffGames()
    {
        return Game::where('category', env('CATEGORY_GAME_PLAYOFF'))->get();
    }

    public function createGames(Collection $data)
    {
        return Game::insert($data->toArray());
    }
}
