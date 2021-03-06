<?php

namespace Artifacts\Http\Controllers;

use Artifacts\Baseball\Player\PlayerInterface;
use Artifacts\Baseball\Teams\TeamsInterface;

class StatisticsController extends Controller
{

    /**
     * The Player Interface
     *
     * @var Artifacts\Player\PlayerInterface
     */
    private $player;

    /**
     * The Teams Interface
     *
     * @var Artifacts\Teams\Teams\Interface
     */
    private $teams;
    /**
     * The player positions array
     *
     * @var array
     */
    private $positions;

    public function __construct(PlayerInterface $player, TeamsInterface $team)
    {
        $this->player = $player;
        $this->team = $team;
        $this->positions = config('positions');
    }

    /**
     * Display statistics
     *
     * @return Response
     */
    public function index()
    {
        // Batting stats
        $most_hrs = $this->player->getMostHomeRuns();
        $most_rbis = $this->player->getMostRBIs();
        $best_average = $this->player->getBestAverage();
        $best_hr_strike_rate = $this->player->getBestHomeRunStrikeRate();
        $best_rbi_strike_rate = $this->player->getBestRBIStrikeRate();

        $most_hrs_by_position = [];
        $most_rbis_by_position = [];
        $best_average_by_position = [];

        foreach ($this->positions as $k => $v):
            if (! in_array($k, ['P', 'OF', 'DH'])):
                $most_hrs_by_position[$v] = $this->player->getMostHomeRuns(['position' => $k]);
                $most_rbis_by_position[$v] = $this->player->getMostRBIs(['position' => $k]);
                $best_average_by_position[$v] = $this->player->getBestAverage(['position' => $k]);
            endif;
        endforeach;

        // Pitching stats
        $most_wins = $this->player->getMostWins();
        $best_era = $this->player->getBestERA();
        $best_win_strike_rate = $this->player->getBestWinStrikeRate();

        // Set stats to view
        return view(
            'statistics',
            [
                'teams'                         => $this->team->getCurrentTeams(),
                'most_home_runs'                => $most_hrs,
                'most_rbis'                     => $most_rbis,
                'best_average'                  => $best_average,
                'most_rbis_by_position'         => $most_rbis_by_position,
                'most_home_runs_by_position'    => $most_hrs_by_position,
                'best_average_by_position'      => $best_average_by_position,
                'best_hr_strike_rate'           => $best_hr_strike_rate,
                'best_rbi_strike_rate'          => $best_rbi_strike_rate,
                'most_wins'                     => $most_wins,
                'best_era'                      => $best_era,
                'best_win_strike_rate'          => $best_win_strike_rate,
            ]
        );
    }

}
