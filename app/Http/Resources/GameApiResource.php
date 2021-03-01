<?php

namespace App\Http\Resources;

use App\Models\Game;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GameApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => Game::$jsonType,
            'category' => $this->category,
            'home_team_id' => $this->home_team_id,
            'away_team_id' => $this->away_team_id,
            'home_team_goals' => $this->home_team_goals,
            'away_team_goals' => $this->away_team_goals,
            'home_team_score' => $this->home_team_score,
            'away_team_score' => $this->away_team_score,
        ];
    }
}
