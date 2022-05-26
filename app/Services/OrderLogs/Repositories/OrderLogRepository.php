<?php

namespace App\Services\OrderLogs\Repositories;

use App\Services\Base\Repository;
use App\Services\OrderLogs\OrderLog;

/**
 * Class OrderLogRepository
 * @package App\Services\OrderLogs\Repositories
 * @author Bryan James Dela Luya
 */

class OrderLogRepository extends Repository implements OrderLogRepositoryInterface
{
    public function __construct(OrderLog $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }
}
