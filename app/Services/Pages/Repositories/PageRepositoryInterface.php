<?php

namespace App\Services\Pages\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class PageRepositoryInterface
 * @package App\Services\Pages\Repositories
 * @author Guevara Web Graphics Studio
 */

interface PageRepositoryInterface extends RepositoryInterface
{
    function fetchPages();

    function addPage(array $data);

    function updatePage(int $id, array $data);

    function pluckNames();

    function getIdByName(string $name);

    function getNameById(int $id);
}