<?php

namespace App\Services\OrderStatus\Repositories;

use App\Services\Base\Repository;
use App\Services\OrderStatus\OrderStatus;

/**
 * Class OrderStatusRepository
 * @package App\Services\OrderStatus\Repositories
 * @author Bryan James Dela Luya
 */

class OrderStatusRepository extends Repository implements OrderStatusRepositoryInterface
{
    public function __construct(OrderStatus $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }
}
