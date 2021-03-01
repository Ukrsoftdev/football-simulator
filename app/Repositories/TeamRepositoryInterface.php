<?php


namespace App\Repositories;


use App\Models\User;

interface TeamRepositoryInterface
{
    public function getAllTeamsByDivision();
    public function getAllTeamsWithScoreByDivision();
}
