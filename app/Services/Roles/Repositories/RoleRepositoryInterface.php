<?php

namespace App\Services\Roles\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class RoleRepositoryInterface
 * @package App\Services\Roles\Repositories
 * @author Guevara Web Graphics Studio
 */

interface RoleRepositoryInterface extends RepositoryInterface
{
    function addRole(array $data);

    function updateRole(int $id, array $data);

    function pluckNames();
}
