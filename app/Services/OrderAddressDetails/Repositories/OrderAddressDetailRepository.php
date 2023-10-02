<?php

namespace App\Services\OrderAddressDetails\Repositories;

use App\Services\Base\Repository;
use App\Services\OrderAddressDetails\OrderAddressDetail;

/**
 * Class OrderAddressDetailRepository
 * @package App\Services\OrderAddressDetails\Repositories
 * @author Guevara Web Graphics Studio
 */

class OrderAddressDetailRepository extends Repository implements OrderAddressDetailRepositoryInterface
{
    public function __construct(OrderAddressDetail $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }
}
