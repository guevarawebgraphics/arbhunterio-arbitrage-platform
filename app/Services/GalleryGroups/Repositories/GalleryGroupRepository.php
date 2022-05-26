<?php

namespace App\Services\GalleryGroups\Repositories;

use App\Services\Base\Repository;
use App\Services\GalleryGroups\GalleryGroup;
use File;

/**
 * Class GalleryGroupRepository
 * @package App\Services\GalleryGroups\Repositories
 * @author Richard Guevara
 */

class GalleryGroupRepository extends Repository implements GalleryGroupRepositoryInterface
{
    public function __construct(GalleryGroup $model)
    {
        $this->model = $model;
    }

    public function fetchGalleryGroup() 
    {
        return $this->model->all();
    }

    public function addGalleryGroup(array $data) 
    {
        return $this->create($data);
    }

    public function updateGalleryGroup(int $id, array $input) 
    {
        $setting = $this->model->find($id);
        $setting->fill($input)->save();
    }

    public function pluckNames()
    {
        return $this->model->pluck('name', 'id')->all();
    }
}
