<?php

namespace App\Http\Controllers;

use App\Repositories\GameRepositoryInterface;
use App\Repositories\TeamRepositoryInterface;

class StandingsController extends Controller
{
    /**
     * @var TeamRepositoryInterface
     */
    private $teamRepository;

    /**
     * @var GameRepositoryInterface
     */
    private $gameRepository;

    public function __construct(
        TeamRepositoryInterface $teamRepository,
        GameRepositoryInterface $gameRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->gameRepository = $gameRepository;
    }

    public function index()
    {
        return view('index', [
            'gamesSeason' => $this->gameRepository->getSeasonGames(),
            'gamesPlayoff' => $this->gameRepository->getPlayoffGames(),
            'teams' => $this->teamRepository->getAllTeamsWithScoreByDivision()
        ]);
    }
}
