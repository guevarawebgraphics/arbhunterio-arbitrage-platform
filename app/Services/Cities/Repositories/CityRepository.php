<?php

namespace App\Services\Cities\Repositories;

use App\Services\Base\Repository;
use App\Services\Cities\City;

/**
 * Class CityRepository
 * @package App\Services\Cities\Repositories
 * @author Guevara Web Graphics Studio
 */

class CityRepository extends Repository implements CityRepositoryInterface
{
    public function __construct(City $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }
}
