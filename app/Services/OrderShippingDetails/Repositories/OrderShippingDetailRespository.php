<?php

namespace App\Services\OrderShippingDetails\Repositories;

use App\Services\Base\Repository;
use App\Services\OrderShippingDetails\OrderShippingDetail;

/**
 * Class OrderShippingDetailRespository
 * @package App\Services\OrderShippingDetails\Repositories
 * @author Bryan James Dela Luya
 */

class OrderShippingDetailRespository extends Repository implements OrderShippingDetailRespositoryInterface
{
    public function __construct(OrderShippingDetail $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }
}
