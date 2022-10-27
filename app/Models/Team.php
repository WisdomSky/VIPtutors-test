<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';
    public $incrementing = false;

    protected $table = 'team';

    protected $fillable = [
        'code',
        'name'
    ];

    public function rosters() {
        return $this->hasMany(Roster::class, 'team_code');
    }

}
