<?php

namespace App\Services\Users\Repositories;

use App\Services\Base\Repository;
use App\Services\Users\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepository
 * @package App\Services\Users\Repositories
 * @author Richard Guevara
 */

class UserRepository extends Repository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function fetchUsers(int $id) 
    {
        return $this->model->where('id', '<>', $id);
    }

    public function addUser(array $data) 
    {
        return $this->create($data);
    }

    public function updateUser(int $id, array $data) 
    {
        $user = $this->model->find($id);
        $user->fill($data)->save();
        return $user;
    }

    public function updateProfile(int $id, array $data) 
    {
        $profile = $this->model->find($id);
        $profile->fill($data)->save();
        return $profile;
    }

    public function updatePassword(int $id, array $data) 
    {
        $profile = $this->model->find($id);
        $profile->fill(['password' => Hash::make($data['password'])])->save();
        return $profile;
    }

    public function updateOrCreateUserBillingAddress($user, $input = []) 
    {
        $billing_address = [];
        $billing_address[] = $user->billing_address()->updateOrCreate(
            [
                'id' => isset($input['billing_id']) ? $input['billing_id'] : 0,
                'user_id' => isset($input['user_id']) ? $input['user_id'] : 0,
                'type' => 1,
            ],
            [
                'user_id' => isset($input['user_id']) ? $input['user_id'] : 0,
                'first_name' => isset($input['billing_first_name']) ? $input['billing_first_name'] : '',
                'last_name' => isset($input['billing_last_name']) ? $input['billing_last_name'] : '',
                'email' => isset($input['billing_email']) ? $input['billing_email'] : '',
                'phone' => isset($input['billing_phone']) ? $input['billing_phone'] : '',
                'ext' => isset($input['billing_ext']) ? $input['billing_ext'] : '',
                'company' => isset($input['billing_company']) ? $input['billing_company'] : '',
                'address' => isset($input['billing_address']) ? $input['billing_address'] : '',
                'address_2' => isset($input['billing_address_2']) ? $input['billing_address_2'] : '',
                'city' => isset($input['billing_city']) ? $input['billing_city'] : '',
                'state' => isset($input['billing_state']) ? $input['billing_state'] : '',
                'zip' => isset($input['billing_zip']) ? $input['billing_zip'] : '',
                'country' => isset($input['billing_country']) ? $input['billing_country'] : '',
                'type' => 1,
            ]);
        return $billing_address;
    }

    public function updateOrCreateUserShippingAddress($user, $input = []) 
    {
        $shipping_address = [];
        $shipping_address[] = $user->shipping_address()->updateOrCreate(
            [
                'id' => isset($input['shipping_id']) ? $input['shipping_id'] : 0,
                'user_id' => isset($input['user_id']) ? $input['user_id'] : 0,
                'type' => 2,
            ],
            [
                'user_id' => isset($input['user_id']) ? $input['user_id'] : 0,
                'first_name' => isset($input['shipping_first_name']) ? $input['shipping_first_name'] : '',
                'last_name' => isset($input['shipping_last_name']) ? $input['shipping_last_name'] : '',
                'email' => isset($input['shipping_email']) ? $input['shipping_email'] : '',
                'phone' => isset($input['shipping_phone']) ? $input['shipping_phone'] : '',
                'ext' => isset($input['shipping_ext']) ? $input['shipping_ext'] : '',
                'company' => isset($input['shipping_company']) ? $input['shipping_company'] : '',
                'address' => isset($input['shipping_address']) ? $input['shipping_address'] : '',
                'address_2' => isset($input['shipping_address_2']) ? $input['shipping_address_2'] : '',
                'city' => isset($input['shipping_city']) ? $input['shipping_city'] : '',
                'state' => isset($input['shipping_state']) ? $input['shipping_state'] : '',
                'zip' => isset($input['shipping_zip']) ? $input['shipping_zip'] : '',
                'country' => isset($input['shipping_country']) ? $input['shipping_country'] : '',
                'type' => 2,
            ]);
        return $shipping_address;
    }
}
