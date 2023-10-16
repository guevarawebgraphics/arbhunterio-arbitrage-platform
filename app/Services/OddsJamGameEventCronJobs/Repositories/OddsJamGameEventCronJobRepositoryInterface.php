<?php

namespace App\Services\OddsJamGameEventCronJobs\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class OddsJamGameEventCronJobRepositoryInterface
 * @package App\Services\OddsJamGameEventCronJobs\Repositories
 * @author Richard Guevara
 */

interface OddsJamGameEventCronJobRepositoryInterface extends RepositoryInterface
{
    function fetchAll();

    function addData(array $data);

    function updateData(int $id, array $data);
}
