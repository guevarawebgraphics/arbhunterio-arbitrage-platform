<?php

namespace App\Services\OddsJamGameEventCronJobs\Repositories;

use App\Services\Base\Repository;
use App\Services\OddsJamGameEventCronJobs\OddsJamGameEventCronJob;

/**
 * Class OddsJamGameEventCronJobRepository
 * @package App\Services\OddsJamGameEventCronJobs\Repositories
 * @author Richard Guevara
 */

class OddsJamGameEventCronJobRepository extends Repository implements OddsJamGameEventCronJobRepositoryInterface
{
    public function __construct(OddsJamGameEventCronJob $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }

    public function addData(array $data)
    {
        return $this->create($data);
    }

    public function updateData(int $id, array $data)
    {
        $updated = $this->model->find($id);
        $updated->fill($data)->save();

        return $updated;
    }
}
