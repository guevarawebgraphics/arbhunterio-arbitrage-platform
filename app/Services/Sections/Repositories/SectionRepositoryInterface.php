<?php

namespace App\Services\Sections\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class SectionRepositoryInterface
 * @package App\Services\Sections\Repositories
 * @author Guevara Web Graphics Studio
 */

interface SectionRepositoryInterface extends RepositoryInterface
{
    function render(string $parameters);

    function find(string $name);
}
