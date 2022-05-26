<?php

namespace App\Services\OrderPaymentDetails\Repositories;

use App\Services\Base\Repository;
use App\Services\OrderPaymentDetails\OrderPaymentDetail;

/**
 * Class OrderPaymentDetailRepository
 * @package App\Services\OrderPaymentDetails\Repositories
 * @author Bryan James Dela Luya
 */

class OrderPaymentDetailRepository extends Repository implements OrderPaymentDetailRepositoryInterface
{
    public function __construct(OrderPaymentDetail $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }
}
