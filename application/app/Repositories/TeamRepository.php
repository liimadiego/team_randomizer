<?php
namespace App\Repositories;

use App\Repositories\Interfaces\TeamRepositoryInterface;
use App\Models\Team;
use App\Repositories\AbstractRepository;

class TeamRepository extends AbstractRepository implements TeamRepositoryInterface
{
    protected $modelClass = Team::class;

}
