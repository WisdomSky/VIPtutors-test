<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $table = 'roster';

    protected $fillable = [
        'team_code',
        'number',
        'name',
        'pos',
        'height',
        'weight',
        'dob',
        'nationality',
        'years_exp',
        'college'
    ];


    public function team()
    {
        return $this->belongsTo(Team::class, 'code','team_code');
    }

    public function info() {
        return $this->hasOne(PlayerTotal::class, 'player_id', 'id');
    }

}
