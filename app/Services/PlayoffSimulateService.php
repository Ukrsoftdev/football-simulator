<?php


namespace App\Services;


use App\Models\Game;
use App\Repositories\GameRepositoryInterface;
use App\Repositories\TeamRepositoryInterface;
use Illuminate\Support\Collection;

class PlayoffSimulateService implements PlayoffSimulateServiceInterface
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

    /**
     * @return void
     */
    public function simulatePlayoff()
    {
        $teams = $this->teamRepository->getAllTeamsWithScoreByDivision();

        $winnerSeasonTeams = $this->getWinnersSeasonByDivision($teams);

        $winnerRoundTeam = $this->simulateQuarterFinalGames($winnerSeasonTeams);

        $winnerRoundTeam = $this->simulateSemiFinalGames($winnerRoundTeam);

        $this->simulateFinalGames($winnerRoundTeam);
    }

    /**
     * @param Collection $teams
     * @return Collection
     */
    private function getWinnersSeasonByDivision(Collection $teams): Collection
    {
        return $teams->map(function ($divTeams) {
            return $divTeams->sortByDesc('scoreSeason')
                ->slice(0, 4);
        });
    }

    /**
     * @param Collection $teams
     * @return array
     */
    private function simulateQuarterFinalGames(Collection $teams): array
    {
        $gamesCollection = $this->planeQuarterFinalGames($teams);

        foreach ($gamesCollection as $key => $game) {
            $gamesCollection[$key] = $this->gameSimulateService->simulateGame($game);
        }

        foreach ($gamesCollection as $key => $game) {
            $gamesCollection[$key] = $this->gameSimulateService->scoreResult($game);
        }

        $this->gameRepository->clearPlayoffGames();
        $this->gameRepository->createGames($gamesCollection);

        return $this->getWinnerQuarterFinalGames($gamesCollection);
    }

    /**
     * @param Collection $teams
     * @return Collection
     */
    private function planeQuarterFinalGames(Collection $teams): Collection
    {
        $games = collect([]);
        $teamsA = $teams->first()->values();
        $teamsB = $teams->last()->values();
        for ($k = 0; $k < 4; $k++) {
            $game = new Game([
                'home_team_id' => ($teamsA[$k])->id,
                'away_team_id' => ($teamsB[3 - $k])->id,
                'category' => env('CATEGORY_GAME_PLAYOFF')
            ]);
            $games->push($game);
        }
        return $games;
    }

    /**
     * @param Collection $gamesCollection
     * @return array
     */
    private function getWinnerQuarterFinalGames(Collection $gamesCollection): array
    {
        $winner = [];
        foreach ($gamesCollection->chunk(2) as $key => $division) {
            foreach ($division as $game) {
                ($game->home_team_score > $game->away_team_score)
                    ? $winner[$key][] = $game['home_team_id'] : $winner[$key][] = $game['away_team_id'];
            }
        }
        return $winner;
    }

    /**
     * @param $winnerRoundTeam
     * @return array
     */
    private function simulateSemiFinalGames($winnerRoundTeam): array
    {
        $gamesCollection = $this->planeSemiFinalGames($winnerRoundTeam);

        foreach ($gamesCollection as $key => $game) {
            $gamesCollection[$key] = $this->gameSimulateService->simulateGame($game);
        }
        foreach ($gamesCollection as $key => $game) {
            $gamesCollection[$key] = $this->gameSimulateService->scoreResult($game);
        }

        $this->gameRepository->createGames($gamesCollection);

        $winner = $this->getWinnerSemiFinalGames($gamesCollection);
        return $winner;
    }

    /**
     * @param array $teamsArray
     * @return Collection
     */
    private function planeSemiFinalGames(array $teamsArray): Collection
    {
        $games = collect([]);
        foreach ($teamsArray as $key => $teams) {
            $game = new Game([
                'home_team_id' => $teams[0],
                'away_team_id' => $teams[1],
                'category' => env('CATEGORY_GAME_PLAYOFF')
            ]);
            $games->push($game);

        }
        return $games;
    }

    /**
     * @param $gamesCollection
     * @return array
     */
    private function getWinnerSemiFinalGames($gamesCollection):array
    {

        $winner = [];
        foreach ($gamesCollection as $key => $game) {
            ($game['home_team_score'] > $game['away_team_score'])
                ? $winner[$key][] = $game['home_team_id'] : $winner[$key][] = $game['away_team_id'];
        }
        return $winner;
    }

    /**
     * @param $winnerRoundTeam
     */
    private function simulateFinalGames(array $winnerRoundTeam)
    {
        $game = $this->planeFinalGames($winnerRoundTeam);

        $game = $this->gameSimulateService->simulateGame($game);

        $game = $this->gameSimulateService->scoreResult($game);

        $this->gameRepository->createGames(collect($game));
    }

    /**
     * @param array $teamsArray
     * @return Game
     */
    private function planeFinalGames(array $teamsArray): Game
    {
        return new Game([
            'home_team_id' => $teamsArray[0][0],
            'away_team_id' => $teamsArray[1][0],
            'category' => env('CATEGORY_GAME_PLAYOFF')
        ]);
    }
}
