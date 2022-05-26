<?php

namespace App\Services\OrderAddressDetails\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderAddressDetailRepositoryInterface
 * @package App\Services\OrderAddressDetails\Repositories
 * @author Bryan James Dela Luya
 */

interface OrderAddressDetailRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
