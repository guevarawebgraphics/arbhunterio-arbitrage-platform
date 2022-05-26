<?php

namespace App\Services\OrderItemDetails\Repositories;

use App\Services\Base\Repository;
use App\Services\OrderItemDetails\OrderItemDetail;

/**
 * Class OrderItemDetailsRepository
 * @package App\Services\OrderItemDetails\Repositories
 * @author Richard Guevara
 */

class OrderItemDetailsRepository extends Repository implements OrderItemDetailsRepositoryInterface
{
    public function __construct(OrderItemDetail $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }
}
