<?php

namespace App\Services\SaveFilters\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class SaveFilterRepositoryInterface
 * @package App\Services\SaveFilters\Repositories
 * @author Richard Guevara
 */

interface SaveFilterRepositoryInterface extends RepositoryInterface
{
    function fetchAll();

    function addData(array $data);

    function updateData(int $id, array $data);
}
