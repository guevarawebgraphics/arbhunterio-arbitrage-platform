<?php

namespace App\Services\OrderCouponDetails\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderCouponDetailsRepositoryInterface
 * @package App\Services\OrderCouponDetails\Repositories
 * @author Guevara Web Graphics Studio
 */

interface OrderCouponDetailsRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
