<?php

namespace App\Services\GamesPerMarkets\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class GamesPerMarketRepositoryInterface
 * @package App\Services\GamesPerMarkets\Repositories
 * @author Richard Guevara
 */

interface GamesPerMarketRepositoryInterface extends RepositoryInterface
{
    function fetchAll();

    function addData(array $data);

    function updateData(int $id, array $data);
}
