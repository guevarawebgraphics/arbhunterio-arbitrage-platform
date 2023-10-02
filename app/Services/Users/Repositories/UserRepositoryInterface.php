<?php

namespace App\Services\Users\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class UserRepositoryInterface
 * @package App\Services\Users\Repositories
 * @author Guevara Web Graphics Studio
 */

interface UserRepositoryInterface extends RepositoryInterface
{
    function fetchUsers(int $id);

    function addUser(array $data);

    function updateUser(int $id, array $data);

    function updateProfile(int $it, array $data);

    function updatePassword(int $it, array $data);

    function updateOrCreateUserBillingAddress($user, $input);

    function updateOrCreateUserShippingAddress($user, $input);
}
