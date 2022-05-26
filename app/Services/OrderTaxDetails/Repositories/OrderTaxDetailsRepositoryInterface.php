<?php

namespace App\Services\OrderTaxDetails\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderTaxDetailsRepositoryInterface
 * @package App\Services\OrderTaxDetails\Repositories
 * @author Bryan James Dela Luya
 */

interface OrderTaxDetailsRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
