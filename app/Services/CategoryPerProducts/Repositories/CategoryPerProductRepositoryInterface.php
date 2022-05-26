<?php

namespace App\Services\CategoryPerProducts\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class CategoryPerProductRepositoryInterface
 * @package App\Services\CategoryPerProducts\Repositories
 * @author Bryan James Dela Luya
 */

interface CategoryPerProductRepositoryInterface extends RepositoryInterface
{
    function fetchAll();

    function createData(array $data);

    function updateData(int $id, array $input);
}
