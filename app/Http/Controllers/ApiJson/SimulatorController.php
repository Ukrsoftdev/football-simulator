<?php

namespace App\Http\Controllers\ApiJson;

use App\Http\Controllers\Controller;
use App\Http\Resources\GameApiResource;
use App\Repositories\GameRepositoryInterface;
use App\Services\PlayoffSimulateServiceInterface;
use App\Services\SeasonSimulateSarviceInterface;

class SimulatorController extends Controller
{
    private $gameRepository;
    private $seasonSimulateService;
    private $playoffSimulateService;

    public function __construct(
        GameRepositoryInterface $gameRepository,
        SeasonSimulateSarviceInterface $seasonSimulateService,
        PlayoffSimulateServiceInterface $playoffSimulateService
    )
    {
        $this->gameRepository = $gameRepository;
        $this->seasonSimulateService = $seasonSimulateService;
        $this->playoffSimulateService = $playoffSimulateService;
    }

    public function simulateSeason()
    {
        $this->seasonSimulateService->simulateSeason();

        return (GameApiResource::collection($this->gameRepository->getSeasonGames()))
            ->response()
            ->setStatusCode(201);
    }

    public function simulatePlayoff()
    {
        $this->playoffSimulateService->simulatePlayoff();

        return (GameApiResource::collection($this->gameRepository->getPlayoffGames()))
            ->response()
            ->setStatusCode(201);
    }
}
