<?php

namespace App\Services\OrderPaymentDetails\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderPaymentDetailRepositoryInterface
 * @package App\Services\OrderPaymentDetails\Repositories
 * @author Guevara Web Graphics Studio
 */

interface OrderPaymentDetailRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
