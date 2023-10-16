<?php

namespace App\Services\SportsBooks\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class SportsBookRepositoryInterface
 * @package App\Services\SportsBooks\Repositories
 * @author Richard Guevara
 */

interface SportsBookRepositoryInterface extends RepositoryInterface
{
    function fetchAll();

    function addData(array $data);

    function updateData(int $id, array $data);
}
