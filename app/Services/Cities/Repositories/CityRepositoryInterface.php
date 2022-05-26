<?php

namespace App\Services\Cities\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class CityRepositoryInterface
 * @package App\Services\Cities\Repositories
 * @author Richard Guevara
 */

interface CityRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
