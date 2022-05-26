<?php

namespace App\Services\OrderTaxDetails\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderTaxDetailsRepositoryInterface
 * @package App\Services\OrderTaxDetails\Repositories
 * @author Richard Guevara
 */

interface OrderTaxDetailsRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
