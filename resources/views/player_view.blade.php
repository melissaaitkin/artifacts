@extends('layouts.app')

@section('content')

    <div class="panel-body content font-weight-bold team-div {{ $player->team }}-div">

        <div class="row">

            <div class="col-sm-3">
                <h2>{{ $player->first_name }} {{ $player->last_name }}</h2>
                <h4>Age: {{ $player->age }}</h4>
            </div>
           <div class="col-lg-4">
                    @if (!empty($player->photo))
                        <div>
                            <img class="img-thumbnail" src="{{ asset('storage/images/regular/' . $player->regular_photo) }}" alt="player_photo">
                        </div>
                    @endif
            </div>
            <div class="col">
                <div class="mt-5 pb-3">
                    {{ $player->city }},
                    @if (!empty($player->state))
                        {{ $player->state_display }}
                    @else
                        {{ $player->country }}
                    @endif
                    <input type="hidden" id="latitude" value="{{ $player->latitude }}">
                    <input type="hidden" id="longitude" value="{{ $player->longitude }}">
                </div>
                <div id="map"></div>
                <div class="ml-5 pt-5">
                     @if (!empty($player->draft_position && $player->draft_position == 1 ))
                        <h5 class="font-italic">1st Pick!</h5>
                     @elseif (!empty($player->draft_round && $player->draft_round == 1 ))
                        <h5 class="font-italic">1st Round Pick!</h5>
                     @endif
                 </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3"></div>
            <div class="mt-2">
                <h4>{{ $team }}</h4>
                <h6>{{ $player->position }}</h6>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3"></div>
            <div class="mt-2 w-33 border rounded p-2">
                @if (!empty($player->draft_year))
                    <div class="row">
                        <div class="col-sm-5 font-weight-normal">Drafted</div>
                        <div class="col-sm-3 text-right">{{ $player->draft_year }}</div>
                    </div>
                @endif
                @if (!empty($player->draft_round))
                    <div class="row">
                        <div class="col-sm-5 font-weight-normal">Round</div>
                       <div class="col-sm-3 text-right">{{ $player->draft_round }}</div>
                    </div>
                @endif
                @if (!empty($player->draft_position))
                    <div class="row">
                        <div class="col-sm-5 font-weight-normal">Position</div>
                        <div class="col-sm-3 text-right">{{ $player->draft_position }}</div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-5 font-weight-normal">Debuted</div>
                    <div class="col-sm-3 text-right">{{ $player->debut_year }}</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3"></div>
            @if ($player->status != 'rookie')
                <div class="mt-2 w-33 border rounded pt-2 px-2">
                    @if (!empty($player->position))
                        @if ($player->position == 'P')
                            <table class="table stats-table">
                                <thead>
                                    <tr>
                                        <th scope="col">ERA</th>
                                        <th scope="col">Games</th>
                                        <th scope="col">IPs</th>
                                        <th scope="col">SOs</th>
                                        <th scope="col">Wins</th>
                                        <th scope="col">Losses</th>
                                        <th scope="col">Saves</th>
                                        <th scope="col">WHIP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $player->era }}</td>
                                        <td>{{ $player->games }}</td>
                                        <td>{{ $player->innings_pitched }}</td>
                                        <td>{{ $player->strike_outs }}</td>
                                        <td>{{ $player->wins }}</td>
                                        <td>{{ $player->losses }}</td>
                                        <td>{{ $player->saves }}</td>
                                        <td>{{ $player->whip }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                        @if (!empty($player->average))
                            <table class="table stats-table">
                                <thead>
                                    <tr>
                                        <th scope="col">AVG</th>
                                        <th scope="col">ABs</th>
                                        <th scope="col">HRs</th>
                                        <th scope="col">RBIs</th>
                                        <th scope="col">Hits</th>
                                        <th scope="col">Runs</th>
                                        <th scope="col">SBs</th>
                                        <th scope="col">OBP</th>
                                        <th scope="col">OPS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $player->average }}</td>
                                        <td>{{ $player->at_bats }}</td>
                                        <td>{{ $player->home_runs }}</td>
                                        <td>{{ $player->rbis }}</td>
                                        <td>{{ $player->hits }}</td>
                                        <td>{{ $player->runs }}</td>
                                        <td>{{ $player->stolen_bases }}</td>
                                        <td>{{ $player->obp }}</td>
                                        <td>{{ $player->ops }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    @endif
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-sm-3"></div>
            <div class="mt-2 previous-teams-div">
                @if (!empty($player->previous_teams))
                    Previous teams: {{ $player->previous_teams_display }}
                @endif
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="{{ asset('js/map.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ $api_key }}&callback=initMap&libraries=&v=weekly" defer></script>
@endsection
