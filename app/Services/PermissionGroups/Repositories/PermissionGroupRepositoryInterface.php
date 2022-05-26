<?php

namespace App\Services\PermissionGroups\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class PermissionGroupRepositoryInterface
 * @package App\Services\PermissionGroups\Repositories
 * @author Richard Guevara
 */

interface PermissionGroupRepositoryInterface extends RepositoryInterface
{
    function getAllWithPermissions();

    function addPermissionGroup(array $data);

    function updatePermissionGroup(int $id, array $data);
}
