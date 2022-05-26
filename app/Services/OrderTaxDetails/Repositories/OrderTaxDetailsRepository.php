<?php

namespace App\Services\OrderTaxDetails\Repositories;

use App\Services\Base\Repository;
use App\Services\OrderTaxDetails\OrderTaxDetail;

/**
 * Class OrderTaxDetailsRepository
 * @package App\Services\OrderTaxDetails\Repositories
 * @author Bryan James Dela Luya
 */

class OrderTaxDetailsRepository extends Repository implements OrderTaxDetailsRepositoryInterface
{
    public function __construct(OrderTaxDetail $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }
}
