<?php

namespace App\Services\PermissionGroups\Repositories;

use App\Services\Base\Repository;
use App\Services\PermissionGroups\PermissionGroup;

/**
 * Class PermissionGroupRepository
 * @package App\Services\PermissionGroups\Repositories
 * @author Guevara Web Graphics Studio
 */

class PermissionGroupRepository extends Repository implements PermissionGroupRepositoryInterface
{
    public function __construct(PermissionGroup $model)
    {
        $this->model = $model;
    }

    public function getAllWithPermissions()
    {
        $items = $this->model->all();
        foreach ($items as $item) {
            $item['permissions'] = $item->permissions()->get();
        }

        return $items;
    }

    public function addPermissionGroup(array $data) 
    {
        return $this->create($data);
    }

    public function updatePermissionGroup(int $id, array $data) 
    {
        $permission_group = $this->model->find($id);
        $permission_group->fill($data)->save();
        return $permission_group;
    }
}
