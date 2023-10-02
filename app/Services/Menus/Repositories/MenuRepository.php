<?php

namespace App\Services\Menus\Repositories;

use App\Services\Base\Repository;
use App\Services\Menus\Menu;

/**
 * Class MenuRepository
 * @package App\Services\Menus\Repositories
 * @author Guevara Web Graphics Studio
 */

class MenuRepository extends Repository implements MenuRepositoryInterface
{
    public function __construct(Menu $model)
    {
        $this->model = $model;
    }

    public function fetchMenus() 
    {
        return $this->model->all();
    }

    public function addMenu(array $data) 
    {
        return $this->create($data);
    }

    public function updateMenu(int $id, array $input) 
    {
        $menu = $this->model->find($id);
        $menu->fill($input)->save();
    }

    public function getOrderings() 
    {
        $start = 1;
        $ordering = array();
        $all = $this->model->all();
        
        return range(1, count($all) + 1);
    }

    public function pluckNames()
    {
        return $this->model->pluck('name','name')->all();
    }

    public function getIdByName(string $name) 
    {
        $menu = $this->model->where('name', $name)->first();
        return ($menu->id ? $menu->id : 0);
    }

    public function getNameById(int $id)
    {
        $page = $this->model->find($id);
        return $page->name;
    }
}
