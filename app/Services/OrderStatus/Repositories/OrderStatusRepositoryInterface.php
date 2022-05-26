<?php

namespace App\Services\OrderStatus\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderStatusRepositoryInterface
 * @package App\Services\OrderStatus\Repositories
 * @author Bryan James Dela Luya
 */

interface OrderStatusRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
