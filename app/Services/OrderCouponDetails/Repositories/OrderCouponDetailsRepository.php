<?php

namespace App\Services\OrderCouponDetails\Repositories;

use App\Services\Base\Repository;
use App\Services\OrderCouponDetails\OrderCouponDetail;

/**
 * Class OrderCouponDetailsRepository
 * @package App\Services\OrderCouponDetails\Repositories
 * @author Bryan James Dela Luya
 */

class OrderCouponDetailsRepository extends Repository implements OrderCouponDetailsRepositoryInterface
{
    public function __construct(OrderCouponDetail $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }
}
