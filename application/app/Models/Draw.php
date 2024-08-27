<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Draw extends Model
{
    use HasFactory;

    protected $table = 'draws';

    protected $fillable = [
        'draw_date',
        'players_per_team',
        'total_teams',
        'confirmed_players'
    ];

    public function teams()
    {
        return $this->hasMany(Team::class, 'draw_id');
    }
}
