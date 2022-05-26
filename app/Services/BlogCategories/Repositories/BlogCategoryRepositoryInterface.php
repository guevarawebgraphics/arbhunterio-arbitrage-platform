<?php

namespace App\Services\BlogCategories\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class BlogCategoryRepositoryInterface
 * @package App\Services\BlogCategories\Repositories
 * @author Bryan James Dela Luya
 */

interface BlogCategoryRepositoryInterface extends RepositoryInterface
{
    function fetchBlogCategories();

    function addBlogCategory(array $data);

    function updateBlogCategory(int $id, array $input);

    function pluckNames();

    function getByName(string $name);
}
