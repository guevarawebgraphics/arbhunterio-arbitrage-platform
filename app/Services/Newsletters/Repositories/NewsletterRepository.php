<?php

namespace App\Services\Newsletters\Repositories;

use App\Services\Base\Repository;
use App\Services\Newsletters\Newsletter;

/**
 * Class NewsletterRepository
 * @package App\Services\Newsletters\Repositories
 * @author Richard Guevara
 */

class NewsletterRepository extends Repository implements NewsletterRepositoryInterface
{
    public function __construct(Newsletter $model)
    {
        $this->model = $model;
    }

    public function fetchNewsletterSubsribers() 
    {
        return $this->model->all();
    }

    public function addNewsletterSubsriber(array $data) 
    {
        return $this->model->firstOrCreate($data);
    }
}
