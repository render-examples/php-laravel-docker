<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use HasFactory;
     protected $fillable = [
            'fixtureId',
            'date',
            'time',
            'place',
            'city',
            'teams_home_name',
            'teams_home_logo',
            'teams_home_goals',
            'teams_away_name',
            'teams_away_logo',
            'teams_away_goals',
        ];
}
