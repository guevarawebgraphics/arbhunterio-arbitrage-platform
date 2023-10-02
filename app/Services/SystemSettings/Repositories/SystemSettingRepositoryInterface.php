<?php

namespace App\Services\SystemSettings\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class SystemSettingRepositoryInterface
 * @package App\Services\SystemSettings\Repositories
 * @author Guevara Web Graphics Studio
 */

interface SystemSettingRepositoryInterface extends RepositoryInterface
{
    function fetchSettings();

    function addSetting(array $data);

    function generateSystemCode(string $code);

    function updateSetting(int $id, array $input, Object $data);

    function uploadFile(Object $file);
}
