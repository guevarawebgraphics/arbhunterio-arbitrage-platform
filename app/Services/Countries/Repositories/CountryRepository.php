<?php

namespace App\Services\Countries\Repositories;

use App\Services\Base\Repository;
use App\Services\Countries\Country;

/**
 * Class CountryRepository
 * @package App\Services\Countries\Repositories
 * @author Richard Guevara
 */

class CountryRepository extends Repository implements CountryRepositoryInterface
{
    public function __construct(Country $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }
}
