<?php

namespace App\Services\Blogs\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class BlogRepositoryInterface
 * @package App\Services\Blogs\Repositories
 * @author Bryan James Dela Luya
 */

interface BlogRepositoryInterface extends RepositoryInterface
{
    function fetchBlogs();

    function addBlog(array $data);

    function updateBlog(int $id, array $input, Object $data);

    function uploadFile(Object $file);

    function getBySlug(string $slug);

    function getByCategory(int $id);
}
