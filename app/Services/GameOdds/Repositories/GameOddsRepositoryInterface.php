<?php

namespace App\Services\GameOdds\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class GameOddsRepositoryInterface
 * @package App\Services\GameOdds\Repositories
 * @author Richard Guevara
 */

interface GameOddsRepositoryInterface extends RepositoryInterface
{
    function fetchAll();

    function addData(array $data);

    function updateData(int $id, array $data);
}
