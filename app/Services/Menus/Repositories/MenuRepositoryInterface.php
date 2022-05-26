<?php

namespace App\Services\Menus\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class MenuRepositoryInterface
 * @package App\Services\Menus\Repositories
 * @author Bryan James Dela Luya
 */

interface MenuRepositoryInterface extends RepositoryInterface
{
    function fetchMenus();

    function addMenu(array $data);

    function updateMenu(int $id, array $input);

    function getOrderings();
    
    function pluckNames();

    function getIdByName(string $name);

    function getNameById(int $id);
}
