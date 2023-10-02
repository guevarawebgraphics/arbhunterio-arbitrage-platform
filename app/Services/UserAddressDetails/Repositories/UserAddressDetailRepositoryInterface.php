<?php

namespace App\Services\UserAddressDetails\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class UserAddressDetailRepositoryInterface
 * @package App\Services\UserAddressDetails\Repositories
 * @author Guevara Web Graphics Studio
 */

interface UserAddressDetailRepositoryInterface extends RepositoryInterface
{
    function fetchUserAddress();

    function addUserAddress(array $data);

    function updateUserAddress(int $id, array $input);
    
}
