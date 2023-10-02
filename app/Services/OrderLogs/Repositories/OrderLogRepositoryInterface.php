<?php

namespace App\Services\OrderLogs\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderLogRepositoryInterface
 * @package App\Services\OrderLogs\Repositories
 * @author Guevara Web Graphics Studio
 */

interface OrderLogRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
