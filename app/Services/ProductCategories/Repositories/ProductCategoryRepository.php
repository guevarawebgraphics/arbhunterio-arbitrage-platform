<?php

namespace App\Services\ProductCategories\Repositories;

use App\Services\Base\Repository;
use App\Services\ProductCategories\ProductCategory;

/**
 * Class ProductCategoryRepository
 * @package App\Services\ProductCategories\Repositories
 * @author Bryan James Dela Luya
 */

class ProductCategoryRepository extends Repository implements ProductCategoryRepositoryInterface
{
    public function __construct(ProductCategory $model)
    {
        $this->model = $model;
    }

    public function fetchProductCategories() 
    {
        return $this->model->all();
    }

    public function addProductCategory(array $data) 
    {
        return $this->create($data);
    }

    public function updateProductCategory(int $id, array $input) 
    {
        $menu = $this->model->find($id);
        $menu->fill($input)->save();
    }

    public function pluckNames()
    {
        return $this->model->pluck('title', 'id')->all();
    }

    public function getNameById(string $name) 
    {
        $data = $this->model->where('title', $name)->first();
        return ($data->id ? $data->id : 0);
    }
}
