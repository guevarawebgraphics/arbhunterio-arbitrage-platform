<?php

namespace App\Services\Cities\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class CityRepositoryInterface
 * @package App\Services\Cities\Repositories
 * @author Bryan James Dela Luya
 */

interface CityRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
