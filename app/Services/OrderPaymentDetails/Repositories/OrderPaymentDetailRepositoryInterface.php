<?php

namespace App\Services\OrderPaymentDetails\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OrderPaymentDetailRepositoryInterface
 * @package App\Services\OrderPaymentDetails\Repositories
 * @author Bryan James Dela Luya
 */

interface OrderPaymentDetailRepositoryInterface extends RepositoryInterface
{
    function fetchAll();
}
