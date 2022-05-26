<?php

namespace App\Services\UserAddressDetails\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class UserAddressDetailRepositoryInterface
 * @package App\Services\UserAddressDetails\Repositories
 * @author Bryan James Dela Luya
 */

interface UserAddressDetailRepositoryInterface extends RepositoryInterface
{
    function fetchUserAddress();

    function addUserAddress(array $data);

    function updateUserAddress(int $id, array $input);
    
}
