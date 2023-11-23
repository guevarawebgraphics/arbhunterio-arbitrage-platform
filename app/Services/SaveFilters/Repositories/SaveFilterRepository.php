<?php

namespace App\Services\SaveFilters\Repositories;

use App\Services\Base\Repository;
use App\Services\SaveFilters\SaveFilter;

/**
 * Class SaveFilterRepository
 * @package App\Services\SaveFilters\Repositories
 * @author Richard Guevara
 */

class SaveFilterRepository extends Repository implements SaveFilterRepositoryInterface
{
    public function __construct(SaveFilter $model)
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
