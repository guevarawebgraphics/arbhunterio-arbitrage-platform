<?php

namespace App\Services\GalleryGroups\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class GalleryGroupRepositoryInterface
 * @package App\Services\GalleryGroups\Repositories
 * @author Bryan James Dela Luya
 */

interface GalleryGroupRepositoryInterface extends RepositoryInterface
{
    function fetchGalleryGroup();

    function addGalleryGroup(array $data);

    function updateGalleryGroup(int $id, array $input);

    function pluckNames();
}
