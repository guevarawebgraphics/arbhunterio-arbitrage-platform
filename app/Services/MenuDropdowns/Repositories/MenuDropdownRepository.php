<?php

namespace App\Services\MenuDropdowns\Repositories;

use App\Services\Base\Repository;
use App\Services\MenuDropdowns\MenuDropdown;

/**
 * Class MenuDropdownRepository
 * @package App\Services\MenuDropdowns\Repositories
 * @author Richard Guevara
 */

class MenuDropdownRepository extends Repository implements MenuDropdownRepositoryInterface
{
    public function __construct(MenuDropdown $model)
    {
        $this->model = $model;
    }

    public function fetchMenuDropdowns() 
    {
        return $this->model->all();
    }

    public function addMenuDropdown(array $data) 
    {
        return $this->create($data);
    }

    public function updateMenuDropdown(int $id, array $input) 
    {
        $menudropdown = $this->model->find($id);
        $menudropdown->fill($input)->save();
    }

    public function getOrderings() 
    {
        $start = 1;
        $ordering = array();
        $all = $this->model->all();
        
        return range(1, count($all) + 1);
    }

}
