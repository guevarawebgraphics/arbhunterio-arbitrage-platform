<?php

namespace App\Services\Games\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class GameRepositoryInterface
 * @package App\Services\Games\Repositories
 * @author Richard Guevara
 */

interface GameRepositoryInterface extends RepositoryInterface
{
    function fetchAll();

    function addData(array $data);

    function updateData(int $id, array $data);
}
