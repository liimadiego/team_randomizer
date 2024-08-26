<?php
namespace App\Repositories;

use App\Repositories\Interfaces\PlayerRepositoryInterface;
use App\Models\Player;
use App\Repositories\AbstractRepository;

class PlayerRepository extends AbstractRepository implements PlayerRepositoryInterface
{
    protected $modelClass = Player::class;

}
