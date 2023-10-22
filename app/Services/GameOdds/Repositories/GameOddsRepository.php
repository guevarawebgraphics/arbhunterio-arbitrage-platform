<?php

namespace App\Services\GameOdds\Repositories;

use App\Services\Base\Repository;
use App\Services\GameOdds\GameOdds;

/**
 * Class GameOddsRepository
 * @package App\Services\GameOdds\Repositories
 * @author Richard Guevara
 */

class GameOddsRepository extends Repository implements GameOddsRepositoryInterface
{
    public function __construct(GameOdds $model)
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
