<?php

namespace App\Services\OrderTaxDetails\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderTaxDetailsRepositoryInterface
 * @package App\Services\OrderTaxDetails\Repositories
 * @author Guevara Web Graphics Studio
 */

interface OrderTaxDetailsRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
