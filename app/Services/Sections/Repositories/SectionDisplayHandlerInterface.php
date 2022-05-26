<?php

namespace App\Services\Sections\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class SectionDisplayHandlerInterface
 * @package App\Services\Sections\Repositories
 * @author Richard Guevara
 */

interface SectionDisplayHandlerInterface extends RepositoryInterface
{
    function render($parameters);

    function find($name);
}
