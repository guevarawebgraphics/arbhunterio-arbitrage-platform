<?php

namespace App\Services\UserAddressDetails\Repositories;

use App\Services\Base\Repository;
use App\Services\UserAddressDetails\UserAddressDetail;

/**
 * Class UserAddressDetailRepository
 * @package App\Services\UserAddressDetails\Repositories
 * @author Richard Guevara
 */

class UserAddressDetailRepository extends Repository implements UserAddressDetailRepositoryInterface
{
    public function __construct(UserAddressDetail $model)
    {
        $this->model = $model;
    }

    public function fetchUserAddress() 
    {
        return $this->model->all();
    }

    public function addUserAddress(array $data) 
    {
        return $this->create($data);
    }

    public function updateUserAddress(int $id, array $input) 
    {
        $data = $this->model->find($id);
        $data->fill($input)->save();
    }

}
