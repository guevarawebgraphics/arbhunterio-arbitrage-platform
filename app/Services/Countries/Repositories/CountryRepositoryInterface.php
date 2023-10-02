<?php

namespace App\Services\Countries\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class CountryRepositoryInterface
 * @package App\Services\Countries\Repositories
 * @author Guevara Web Graphics Studio
 */

interface CountryRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
