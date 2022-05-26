<?php

namespace App\Services\CouponCodes\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class CouponCodeRepositoryInterface
 * @package App\Services\CouponCodes\Repositories
 * @author Richard Guevara
 */

interface CouponCodeRepositoryInterface extends RepositoryInterface
{
    function fetchAll();

    function addData(array $input);

    function updateData(int $id, array $input);
}
