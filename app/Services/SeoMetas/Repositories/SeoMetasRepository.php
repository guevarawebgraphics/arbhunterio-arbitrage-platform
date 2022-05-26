<?php

namespace App\Services\SeoMetas\Repositories;

use App\Services\Base\Repository;
use App\Services\SeoMetas\SeoMeta;
use File;

/**
 * Class SeoMetasRepository
 * @package App\Services\SeoMetas\Repositories
 * @author Richard Guevara
 */

class SeoMetasRepository extends Repository implements SeoMetasRepositoryInterface
{
    public function __construct(SeoMeta $model)
    {
        $this->model = $model;
    }

    public function fetchSeoMetas()
    {
        return $this->model->all();
    }

    public function updateOrCreateSeoMetas(array $data) 
    {
        return $this->model->updateOrCreate(['id' => $data['seo_meta_id']], $data);
    }
}