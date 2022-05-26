<?php

namespace App\Services\GalleryImages\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class GalleryImageRepositoryInterface
 * @package App\Services\GalleryImages\Repositories
 * @author Bryan James Dela Luya
 */

interface GalleryImageRepositoryInterface extends RepositoryInterface
{
    function fetchGalleryImages();

    function addGalleryImage(array $data);

    function updateGalleryImage(int $id, array $input, Object $data);

    function uploadFile(Object $file);
}
