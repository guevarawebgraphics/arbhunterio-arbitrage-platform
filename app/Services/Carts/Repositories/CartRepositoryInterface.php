<?php

namespace App\Services\Carts\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class CartRepositoryInterface
 * @package App\Services\Carts\Repositories
 * @author Bryan James Dela Luya
 */

interface CartRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
