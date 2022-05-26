<?php

namespace App\Services\Permissions\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class PermissionRepositoryInterface
 * @package App\Services\Permissions\Repositories
 * @author Bryan James Dela Luya
 */

interface PermissionRepositoryInterface extends RepositoryInterface
{
    function getAllWithPermissionGroup();

    function get(string $id);

    function addPermission(array $data);

    function updatePermission(int $id, array $data);
}
