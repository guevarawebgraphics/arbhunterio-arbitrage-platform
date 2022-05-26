<?php

namespace App\Services\States\Repositories;

use App\Services\Base\Repository;
use App\Services\States\State;

/**
 * Class StateRepository
 * @package App\Services\States\Repositories
 * @author Bryan James Dela Luya
 */

class StateRepository extends Repository implements StateRepositoryInterface
{
    public function __construct(State $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->orderBy('id', 'asc');
    }

    public function updateData(int $id, array $input) 
    {
        $data = $this->model->find($id);
        $data->fill($input)->save();
    }
}
