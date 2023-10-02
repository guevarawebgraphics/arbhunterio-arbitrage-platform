<?php

namespace App\Services\BlogCategories\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class BlogCategoryRepositoryInterface
 * @package App\Services\BlogCategories\Repositories
 * @author Guevara Web Graphics Studio
 */

interface BlogCategoryRepositoryInterface extends RepositoryInterface
{
    function fetchBlogCategories();

    function addBlogCategory(array $data);

    function updateBlogCategory(int $id, array $input);

    function pluckNames();

    function getByName(string $name);
}
