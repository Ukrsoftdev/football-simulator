<?php


namespace App\Repositories;


use App\Models\User;
use Illuminate\Support\Collection;

interface GameRepositoryInterface
{
    public function clearAllGames();
    public function getSeasonGames();
    public function getPlayoffGames();
    public function createGames(Collection $data);

    public function getAllGamesForStandings();
}
