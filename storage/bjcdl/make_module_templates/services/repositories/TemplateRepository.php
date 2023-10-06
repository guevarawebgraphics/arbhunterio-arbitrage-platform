<?php

namespace App\Services\DefaultServicePlural\Repositories;

use App\Services\Base\Repository;
use App\Services\DefaultServicePlural\DefaultService;

/**
 * Class DefaultServiceRepository
 * @package App\Services\DefaultServicePlural\Repositories
 * @author Richard Guevara
 */

class DefaultServiceRepository extends Repository implements DefaultServiceRepositoryInterface
{
    public function __construct(DefaultService $model)
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
