<?php

namespace App\Services\OrderItemDetails\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderItemDetailsRepositoryInterface
 * @package App\Services\OrderItemDetails\Repositories
 * @author Bryan James Dela Luya
 */

interface OrderItemDetailsRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
