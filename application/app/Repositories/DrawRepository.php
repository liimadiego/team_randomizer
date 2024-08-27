<?php
namespace App\Repositories;

use App\Repositories\Interfaces\DrawRepositoryInterface;
use App\Models\Draw;
use App\Repositories\AbstractRepository;

class DrawRepository extends AbstractRepository implements DrawRepositoryInterface
{
    protected $modelClass = Draw::class;

    public function getDrawTeamsPlayers($drawId)
    {
        $draw = app(Draw::class)->with('teams.players')->find($drawId);

        if (!$draw) {
            return null;
        }

        return $draw;
    }

}
