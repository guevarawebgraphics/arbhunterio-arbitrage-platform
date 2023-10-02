<?php

namespace App\Services\BlogCategories\Repositories;

use App\Services\Base\Repository;
use App\Services\BlogCategories\BlogCategory;
use File;

/**
 * Class BlogCategoryRepository
 * @package App\Services\BlogCategories\Repositories
 * @author Guevara Web Graphics Studio
 */

class BlogCategoryRepository extends Repository implements BlogCategoryRepositoryInterface
{
    public function __construct(BlogCategory $model)
    {
        $this->model = $model;
    }

    public function fetchBlogCategories() 
    {
        return $this->model->all();
    }

    public function addBlogCategory(array $data) 
    {
        return $this->create($data);
    }

    public function updateBlogCategory(int $id, array $input) 
    {
        $setting = $this->model->find($id);
        $setting->fill($input)->save();
    }

    public function pluckNames()
    {
        return $this->model->pluck('name', 'id')->all();
    }

    public function getByName(string $name) 
    {
        $category = $this->model->where('name', $name)->first();
        if ($category) {
            return $category;
        } else {
            abort('404', '404');
        }
    }
}
