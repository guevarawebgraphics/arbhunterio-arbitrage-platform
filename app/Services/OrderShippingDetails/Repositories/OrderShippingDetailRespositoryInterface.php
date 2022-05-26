<?php

namespace App\Services\OrderShippingDetails\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderShippingDetailRespositoryInterface
 * @package App\Services\OrderShippingDetails\Repositories
 * @author Bryan James Dela Luya
 */

interface OrderShippingDetailRespositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
