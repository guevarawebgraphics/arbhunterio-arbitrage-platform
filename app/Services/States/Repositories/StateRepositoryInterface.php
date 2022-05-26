<?php

namespace App\Services\States\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class StateRepositoryInterface
 * @package App\Services\States\Repositories
 * @author Richard Guevara
 */

interface StateRepositoryInterface extends RepositoryInterface
{
    function fetchAll();

    function updateData(int $id, array $input);
}
