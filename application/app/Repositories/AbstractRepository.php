<?php

namespace App\Repositories;

abstract class AbstractRepository
{
    /**
     * @var string
     */
    protected $modelClass;

    public function findAll()
    {
        return $this->modelClass::all();
    }
    
    public function findOne($id)
    {
        return app($this->modelClass)->find($id);
    }
    
    public function create($data)
    {
        return app($this->modelClass)
            ->create($data);
    }
    
    public function updateById($data, $id)
    {
        return app($this->modelClass)
            ->where('id', $id)
            ->update($data);
    }
    
    public function destroy($id)
    {
        return app($this->modelClass)
            ->where('id', $id)
            ->delete();
    }

    public function paginate($perPage = 15)
    {
        return app($this->modelClass)->orderBy('id', 'desc')->paginate($perPage);
    }
}
