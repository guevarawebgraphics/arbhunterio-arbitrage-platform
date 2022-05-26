<?php

namespace App\Services\OrderLogs\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderLogRepositoryInterface
 * @package App\Services\OrderLogs\Repositories
 * @author Bryan James Dela Luya
 */

interface OrderLogRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
