<?php


namespace App\Services;


use App\Models\Game;
use App\Repositories\GameRepositoryInterface;
use App\Repositories\TeamRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SeasonSimulateSarvice implements SeasonSimulateSarviceInterface
{
    /**
     * @var TeamRepositoryInterface
     */
    private $teamRepository;

    /**
     * @var GameRepositoryInterface
     */
    private $gameRepository;

    /**
     * @var GameSimulateServiceInterface
     */
    private $gameSimulateService;

    public function __construct(
        TeamRepositoryInterface $teamRepository,
        GameRepositoryInterface $gameRepository,
        GameSimulateServiceInterface $gameSimulateService
    )
    {
        $this->teamRepository = $teamRepository;
        $this->gameRepository = $gameRepository;
        $this->gameSimulateService = $gameSimulateService;
    }

    public function simulateSeason()
    {
        try {
            DB::beginTransaction();
            $teams = $this->teamRepository->getAllTeamsByDivision();

            // Planning games for the future, with all Teams
            $gamesCollection = $this->createEmptySeasonGames($teams);

            // Play (simulate) all games
            foreach ($gamesCollection as $key => $game) {
                $gamesCollection[$key] = $this->gameSimulateService->simulateGame($game);
            }

            // Scoring results games
            foreach ($gamesCollection as $key => $game) {
                $gamesCollection[$key] = $this->gameSimulateService->scoreResult($game);
            }

            // Clear old Games and Save new GamesCollection in DB
            $this->gameRepository->clearAllGames();
            $createdGames = $this->gameRepository->createGames($gamesCollection);

            DB::commit();

            return $createdGames;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * @param Collection $teamsArray
     * @return Collection
     */
    private function createEmptySeasonGames(Collection $teamsArray): Collection
    {
        $games = collect([]);
        foreach ($teamsArray as $division => $teams) {
            foreach ($teams as $keyHome => $homeTeam) {
                $awayTeams = $teams->slice($keyHome + 1);
                if (!empty($awayTeams)) {
                    foreach ($awayTeams as $keyAway => $awayTeam) {
                        if ($homeTeam['id'] === $awayTeam['id']) continue;

                        $gameHome = new Game(['category' => env('CATEGORY_GAME_SEASON')]);
                        $gameHome->home_team_id = $homeTeam['id'];
                        $gameHome->away_team_id = $awayTeam['id'];
                        $games->push($gameHome);

                        $gameAway = new Game(['category' => env('CATEGORY_GAME_SEASON')]);
                        $gameAway->home_team_id = $awayTeam['id'];
                        $gameAway->away_team_id = $homeTeam['id'];
                        $games->push($gameAway);
                    }
                }
            }
        }
        return $games;
    }
}
