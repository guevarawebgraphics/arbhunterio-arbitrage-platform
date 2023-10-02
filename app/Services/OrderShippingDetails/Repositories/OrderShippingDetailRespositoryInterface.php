<?php

namespace App\Services\OrderShippingDetails\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderShippingDetailRespositoryInterface
 * @package App\Services\OrderShippingDetails\Repositories
 * @author Guevara Web Graphics Studio
 */

interface OrderShippingDetailRespositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
