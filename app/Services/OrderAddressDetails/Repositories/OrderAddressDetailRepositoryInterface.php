<?php

namespace App\Services\OrderAddressDetails\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderAddressDetailRepositoryInterface
 * @package App\Services\OrderAddressDetails\Repositories
 * @author Guevara Web Graphics Studio
 */

interface OrderAddressDetailRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
