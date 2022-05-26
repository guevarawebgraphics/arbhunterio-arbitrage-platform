<?php

namespace App\Services\OrderStatus\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderStatusRepositoryInterface
 * @package App\Services\OrderStatus\Repositories
 * @author Richard Guevara
 */

interface OrderStatusRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
