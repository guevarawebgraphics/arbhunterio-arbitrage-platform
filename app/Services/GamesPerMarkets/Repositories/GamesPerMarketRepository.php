<?php

namespace App\Services\GamesPerMarkets\Repositories;

use App\Services\Base\Repository;
use App\Services\GamesPerMarkets\GamesPerMarket;

/**
 * Class GamesPerMarketRepository
 * @package App\Services\GamesPerMarkets\Repositories
 * @author Richard Guevara
 */

class GamesPerMarketRepository extends Repository implements GamesPerMarketRepositoryInterface
{
    public function __construct(GamesPerMarket $model)
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
