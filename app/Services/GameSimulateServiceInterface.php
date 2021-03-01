<?php


namespace App\Services;


use App\Models\Game;

interface GameSimulateServiceInterface
{
    public function simulateGame(Game $game);
    public function scoreResult(Game $game);
}
