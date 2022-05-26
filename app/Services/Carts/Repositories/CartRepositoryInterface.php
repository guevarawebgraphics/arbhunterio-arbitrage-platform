<?php

namespace App\Services\Carts\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class CartRepositoryInterface
 * @package App\Services\Carts\Repositories
 * @author Richard Guevara
 */

interface CartRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
