<?php

namespace App\Services\ProductCategories\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class ProductCategoryRepositoryInterface
 * @package App\Services\ProductCategories\Repositories
 * @author Richard Guevara
 */

interface ProductCategoryRepositoryInterface extends RepositoryInterface
{
    function fetchProductCategories();

    function addProductCategory(array $data);

    function updateProductCategory(int $id, array $input);

    function pluckNames();

    function getNameById(string $name);
}
