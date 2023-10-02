<?php

namespace App\Services\CategoryPerProducts\Repositories;

use App\Services\Base\Repository;
use App\Services\CategoryPerProducts\CategoryPerProduct;

/**
 * Class CategoryPerProductRepository
 * @package App\Services\CategoryPerProducts\Repositories
 * @author Guevara Web Graphics Studio
 */

class CategoryPerProductRepository extends Repository implements CategoryPerProductRepositoryInterface
{
    public function __construct(CategoryPerProduct $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }

    public function createData(array $data) 
    {
        return $this->create($data);
    }

    public function updateData(int $id, array $input) 
    {
        $data = $this->model->find($id);
        $data->fill($input)->save();
    }
}
