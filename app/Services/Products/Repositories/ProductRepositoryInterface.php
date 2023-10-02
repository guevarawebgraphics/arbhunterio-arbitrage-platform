<?php

namespace App\Services\Products\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class ProductRepositoryInterface
 * @package App\Services\Products\Repositories
 * @author Guevara Web Graphics Studio
 */

interface ProductRepositoryInterface extends RepositoryInterface
{
    function fetchAll();

    function addProduct(array $data);

    function updateProduct(int $id, array $input);

    function uploadFile(Object $file);

    function galleryUpload(int $id, Object $request);

    function galleryUploadOnCreate(int $id, Object $request);
}
