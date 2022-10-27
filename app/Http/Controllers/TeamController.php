<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index() {
        $teams = Team::all();

        return response($teams);
    }


    public function show(Team $team) {
        return response($team->rosters);
    }


}
