<?php

namespace App\Services\Cities\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class CityRepositoryInterface
 * @package App\Services\Cities\Repositories
 * @author Guevara Web Graphics Studio
 */

interface CityRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
