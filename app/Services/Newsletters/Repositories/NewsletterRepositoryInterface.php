<?php

namespace App\Services\Newsletters\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class NewsletterRepositoryInterface
 * @package App\Services\Contacts\Repositories
 * @author Richard Guevara
 */

interface NewsletterRepositoryInterface extends RepositoryInterface
{
    function fetchNewsletterSubsribers();

    function addNewsletterSubsriber(array $data);
}
