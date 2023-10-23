<?php

namespace App\Services\Games\Repositories;

use App\Services\Base\Repository;
use App\Services\Games\Game;

/**
 * Class GameRepository
 * @package App\Services\Games\Repositories
 * @author Richard Guevara
 */

class GameRepository extends Repository implements GameRepositoryInterface
{
    public function __construct(Game $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }

    public function addData(array $data)
    {
        return $this->create($data);
    }

    public function updateData(int $id, array $data)
    {
        $updated = $this->model->find($id);
        $updated->fill($data)->save();

        return $updated;
    }
}
