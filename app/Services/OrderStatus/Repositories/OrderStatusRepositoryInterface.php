<?php

namespace App\Services\OrderStatus\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderStatusRepositoryInterface
 * @package App\Services\OrderStatus\Repositories
 * @author Guevara Web Graphics Studio
 */

interface OrderStatusRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
