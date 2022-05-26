<?php

namespace App\Services\Permissions\Repositories;

use App\Services\Base\Repository;
use Spatie\Permission\Models\Permission;
use App\Services\PermissionGroups\PermissionGroup;

/**
 * Class PermissionRepository
 * @package App\Services\Permissions\Repositories
 * @author Richard Guevara
 */

class PermissionRepository extends Repository implements PermissionRepositoryInterface
{
    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    public function getAllWithPermissionGroup()
    {
        $items = $this->model->all();
        foreach ($items as $item) {
            $item['permission_group'] = PermissionGroup::findOrFail($item->permission_group_id);
        }

        return $items;
    }

    /**
     * Get single instance
     *
     * @param  $id
     *
     * @return \Spatie\Permission\Models\Permission;
     */
    public function get(string $id)
    {
        $item = $this->model->findOrFail($id);
        return $item;
    }

    public function addPermission(array $data)
    {
        return $this->create($data);
    }

    public function updatePermission(int $id, array $data) 
    {
        $permission = $this->model->find($id);
        $permission->fill($data)->save();
        return $permission;
    }
}
