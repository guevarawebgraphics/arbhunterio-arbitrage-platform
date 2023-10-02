<?php

namespace App\Services\Orders\Repositories;

use App\Services\Base\Repository;
use App\Services\Orders\Order;

/**
 * Class OrderRepository
 * @package App\Services\Orders\Repositories
 * @author Guevara Web Graphics Studio
 */

class OrderRepository extends Repository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }
}
