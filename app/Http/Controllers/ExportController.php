<?php

namespace App\Http\Controllers;

use App\Models\PlayerTotal;
use App\Models\Roster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NunoMaduro\Collision\Writer;

class ExportController extends Controller
{
    public function index(Request $request) {
        $type = $request->input('type', 'playerstats');
        $format = $request->input('format', 'csv');

        // switch main query based on result type. either player or playerstats
        if ($type === 'players') {
            $query = Roster::query()->select(DB::raw('roster.*'));
        } else {
            $query = PlayerTotal::query()->select(
                'player_totals.*', 'roster.*');
            // join roster table to allow search by team
            $query->join('roster', 'roster.id', '=', 'player_totals.player_id');
        }

        // join team
        $query->join('team', 'team.code', '=', 'roster.team_code');

        $team = $request->input('team', null);
        if (!is_null($team)) {
            $query->where('team.code', '=', $team);
        }

        // player filter
        $player = $request->input('player', null);
        if (!is_null($player)) {
            $query->where('roster.name', 'LIKE', "%{$player}%");
        }

        $results = $query->get();


        return response()->streamDownload(function () use ($format, $results) {

            switch ($format) {
                case "json":
                    echo json_encode($results);
                    break;
                default:
                    if ($results->count()) {
                        echo implode(',',array_keys($results->first()->toArray()));
                        echo "\n";
                        foreach ($results as $result) {
                            echo implode(',',array_values($result->toArray()));
                            echo "\n";
                        }
                    }
                    break;
            }


        }, 'export.' . $format);



    }
}
