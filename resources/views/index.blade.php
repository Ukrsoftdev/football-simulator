@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Football standings</h1>
        <div class="card">
            <div class="card-body">
                <div class="card-header text-center">
                    <h2>SimulatorGames</h2>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <button onclick="simulate('1')" class="btn btn-outline-success">Simulate Season
                            Games
                        </button>
                    </div>
                    @if($gamesPlayoff->count() !== 0 )
                        <div class="col">
                            <button onclick="simulate('2')" class="btn btn-outline-success">Simulate Playoff
                                Games
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-header text-center">
                    <h2>Season Games</h2>
                </div>
                <div class="row">
                    @foreach($teams as $division=>$divTeams)
                        <div class="col-6 text-center">
                            <h3>Division {!! $division !!}</h3>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Teams</th>
                                    @foreach($divTeams as $keyAway => $teamAway)
                                        <th>{!! $teamAway->title !!}</th>
                                    @endforeach
                                    <th>Score</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($divTeams as $keyHome => $teamHome)

                                    <tr>
                                        <td scope="row">{!! $teamHome->title !!}</td>
                                        @foreach($divTeams as $keyAway => $teamAway)
                                            @if($teamHome->id === $teamAway->id)
                                                <td> - : -</td>
                                                @continue
                                            @endif
                                            @php
                                                $game = $gamesSeason->where('home_team_id',$teamHome->id)
                                                            ->where('away_team_id',$teamAway->id)
                                                            ->first();
                                            @endphp
                                            <td>
                                                {{ isset($game->id)? "$game->home_team_goals : $game->away_team_goals" : ''}}
                                            </td>
                                        @endforeach
                                        <td>{!! $teamHome->scoreSeason !!}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card mt-5">
            <div class="card-body">
                <div class="card-header text-center">
                    <h2>Playoff Games</h2>
                </div>
                <div class="row">
                    @if($gamesPlayoff->count() !== 0 )
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header text-center">
                                        Quarter Final Games
                                    </div>
                                    @php $gamesQuarterFinal = $gamesPlayoff->slice(0,4) @endphp
                                    @foreach($gamesQuarterFinal as $game)
                                        @php $divTeams = $teams->first()->merge($teams->last()); @endphp
                                        <div class="card mt-2">
                                            <div class="card-body">
                                                @php
                                                    $homeTeam =$divTeams->where('id',$game->home_team_id)->first();
                                                    $awayTeam =$divTeams->where('id',$game->away_team_id)->first();
                                                @endphp
                                                <div class="row align-items-center">
                                                    <div class="col-9">
                                                        <p>{{isset($homeTeam->title)? $homeTeam->title : ''}}
                                                            (Division {{isset($homeTeam->division)? $homeTeam->division : ''}}
                                                            )</p>
                                                        <hr>
                                                        <p>{{isset($awayTeam->title)? $awayTeam->title : ''}}
                                                            (Division {{isset($awayTeam->division)? $awayTeam->division : ''}}
                                                            )</p>
                                                    </div>
                                                    <div class="col-3">
                                                        {!! $game->home_team_score !!} : {!! $game->away_team_score !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header text-center">
                                        Semi Final Games
                                    </div>
                                    @php $gamesSemiFinal = $gamesPlayoff->slice(4,2) @endphp

                                    @foreach($gamesSemiFinal as $game)
                                        @php $divTeams = $teams->first()->merge($teams->last()); @endphp
                                        <div class="card mt-2">
                                            <div class="card-body">
                                                @php
                                                    $homeTeam =$divTeams->where('id',$game->home_team_id)->first();
                                                    $awayTeam =$divTeams->where('id',$game->away_team_id)->first()
                                                @endphp
                                                <div class="row align-items-center">
                                                    <div class="col-9">
                                                        <p>{{isset($homeTeam->title)? $homeTeam->title : ''}}
                                                            (Division {{isset($homeTeam->division)? $homeTeam->division : ''}}
                                                            )</p>
                                                        <hr>
                                                        <p>{{isset($awayTeam->title)? $awayTeam->title : ''}}
                                                            (Division {{isset($awayTeam->division)? $awayTeam->division : ''}}
                                                            )</p>
                                                    </div>
                                                    <div class="col-3">
                                                        {!! $game->home_team_score !!} : {!! $game->away_team_score !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header text-center">
                                        Final Game
                                    </div>
                                    <div class="card mt-2">
                                        <div class="card-body">
                                            @php
                                                $gameFinal = $gamesPlayoff->last();
                                                $divTeams = $teams->first()->merge($teams->last());
                                                $homeTeam =$divTeams->first()->where('id',$gameFinal->home_team_id)->first();
                                                $awayTeam =$divTeams->last()->where('id',$gameFinal->away_team_id)->first();
                                            @endphp
                                            <div class="row align-items-center">
                                                <div class="col-9">
                                                    <p>{{isset($homeTeam->title)? $homeTeam->title : ''}}
                                                        (Division {{isset($homeTeam->division)? $homeTeam->division : ''}}
                                                        )</p>
                                                    <hr>
                                                    <p>{{isset($awayTeam->title)? $awayTeam->title : ''}}
                                                        (Division {{isset($awayTeam->division)? $awayTeam->division : ''}}
                                                        )</p>
                                                </div>
                                                <div class="col-3">
                                                    {!! $game->home_team_score !!} : {!! $game->away_team_score !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header text-center">
                                        Result Games
                                    </div>
                                    <table class="table table-hover">
                                        <tbody>
                                        @foreach($gamesPlayoff as $game)
                                            <tr>
                                                @php $allTeams = $teams->first(); $allTeams =$allTeams->merge($teams->last()) @endphp
                                                @php
                                                    $homeTeam =$allTeams->where('id',$game->home_team_id)->first();
                                                    $awayTeam =$allTeams->where('id',$game->away_team_id)->first()
                                                @endphp
                                                <td>{{isset($homeTeam->title)? $homeTeam->title : ''}}
                                                    ({{isset($homeTeam->division)? $homeTeam->division : ''}})
                                                </td>
                                                <td>{{isset($awayTeam->title)? $awayTeam->title : ''}}
                                                    ({{isset($awayTeam->division)? $awayTeam->division : ''}})
                                                </td>
                                                <td>{!! $game->home_team_goals !!}
                                                    : {!! $game->away_team_goals !!}</td>
                                                <td>{!! $game->home_team_score !!}
                                                    : {!! $game->away_team_score !!}</td>

                                            </tr>
                                            @if ($loop->iteration === 4 || $loop->iteration === 6 )
                                                <tr>
                                                    <td colspan="4">Next Round</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
@endsection
