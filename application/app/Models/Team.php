<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $table = 'teams';

    protected $fillable = [
        'draw_id',
        'name',
    ];

    public function draw()
    {
        return $this->belongsTo(Draw::class, 'draw_id');
    }

    public function players()
    {
        return $this->belongsToMany(Player::class, 'player_team');
    }
}
