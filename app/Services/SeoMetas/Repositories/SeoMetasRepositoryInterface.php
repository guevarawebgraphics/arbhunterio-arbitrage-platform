<?php

namespace App\Services\SeoMetas\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class SeoMetasRepositoryInterface
 * @package App\Services\SeoMetas\Repositories
 * @author Richard Guevara
 */

interface SeoMetasRepositoryInterface extends RepositoryInterface
{
    function fetchSeoMetas();

    function updateOrCreateSeoMetas(array $data);
}