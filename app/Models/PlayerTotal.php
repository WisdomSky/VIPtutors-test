<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerTotal extends Model
{
    use HasFactory;


    protected $primaryKey = 'player_id';
    public $incrementing = false;

    protected $table = 'player_totals';

    protected $fillable = [
        'age',
        'games',
        'games_started',
        'minutes_played',
        'field_goals',
        'field_goals_attempted',
        '3pt',
        '3pt_attempted',
        '2pt',
        '2pt_attempted',
        'free_throws',
        'free_throws_attempted',
        'offensive_rebounds',
        'defensive_rebounds',
        'assists',
        'steals',
        'blocks',
        'turnovers',
        'personal_fouls'
    ];


    public function player()
    {
        return $this->belongsTo(Roster::class, 'id','player_id');
    }


}
