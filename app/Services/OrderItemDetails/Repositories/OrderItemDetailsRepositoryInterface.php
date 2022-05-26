<?php

namespace App\Services\OrderItemDetails\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderItemDetailsRepositoryInterface
 * @package App\Services\OrderItemDetails\Repositories
 * @author Richard Guevara
 */

interface OrderItemDetailsRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
