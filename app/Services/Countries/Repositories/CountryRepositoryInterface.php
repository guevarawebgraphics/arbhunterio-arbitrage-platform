<?php

namespace App\Services\Countries\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class CountryRepositoryInterface
 * @package App\Services\Countries\Repositories
 * @author Richard Guevara
 */

interface CountryRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
