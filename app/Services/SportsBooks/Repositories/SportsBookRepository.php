<?php

namespace App\Services\SportsBooks\Repositories;

use App\Services\Base\Repository;
use App\Services\SportsBooks\SportsBook;

/**
 * Class SportsBookRepository
 * @package App\Services\SportsBooks\Repositories
 * @author Richard Guevara
 */

class SportsBookRepository extends Repository implements SportsBookRepositoryInterface
{
    public function __construct(SportsBook $model)
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
