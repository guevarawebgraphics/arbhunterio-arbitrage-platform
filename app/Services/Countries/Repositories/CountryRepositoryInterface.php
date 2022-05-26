<?php

namespace App\Services\Countries\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class CountryRepositoryInterface
 * @package App\Services\Countries\Repositories
 * @author Bryan James Dela Luya
 */

interface CountryRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
