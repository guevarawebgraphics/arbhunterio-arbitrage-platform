<?php

namespace App\Services\DefaultServicePlural\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class DefaultServiceRepositoryInterface
 * @package App\Services\DefaultServicePlural\Repositories
 * @author Richard Guevara
 */

interface DefaultServiceRepositoryInterface extends RepositoryInterface
{
    function fetchAll();

    function addData(array $data);

    function updateData(int $id, array $data);
}
