<?php

namespace App\Services\Orders\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderRepositoryInterface
 * @package App\Services\Orders\Repositories
 * @author Richard Guevara
 */

interface OrderRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
