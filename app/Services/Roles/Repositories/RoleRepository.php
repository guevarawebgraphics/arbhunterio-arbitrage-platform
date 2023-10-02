<?php

namespace App\Services\Roles\Repositories;

use App\Services\Base\Repository;
use Spatie\Permission\Models\Role;

/**
 * Class RoleRepository
 * @package App\Services\Roles\Repositories
 * @author Guevara Web Graphics Studio
 */

class RoleRepository extends Repository implements RoleRepositoryInterface
{
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function addRole(array $data)
    {
        return $this->create($data);
    }

    public function updateRole(int $id, array $data)
    {
        $role = $this->model->find($id);
        $role->fill($data)->save();
        return $role;
    }

    public function pluckNames()
    {
        return $this->model->pluck('name','name')->all();
    }
}
