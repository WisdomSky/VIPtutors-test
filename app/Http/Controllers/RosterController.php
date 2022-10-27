<?php

namespace App\Http\Controllers;

use App\Models\Roster;
use Illuminate\Http\Request;

class RosterController extends Controller
{
    public function show(Roster $roster) {
        return response($roster->info);
    }
}
