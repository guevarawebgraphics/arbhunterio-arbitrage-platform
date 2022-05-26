<?php

namespace App\Services\MenuDropdowns\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class MenuDropdownRepositoryInterface
 * @package App\Services\MenuDropdowns\Repositories
 * @author Bryan James Dela Luya
 */

interface MenuDropdownRepositoryInterface extends RepositoryInterface
{
    function fetchMenuDropdowns();

    function addMenuDropdown(array $data);

    function updateMenuDropdown(int $id, array $input);

    function getOrderings();
    
}
