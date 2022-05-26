<?php

namespace App\Services\SystemSettings\Repositories;

use App\Services\Base\Repository;
use App\Services\SystemSettings\SystemSetting;
use File;

/**
 * Class SystemSettingRepository
 * @package App\Services\SystemSettings\Repositories
 * @author Richard Guevara
 */

class SystemSettingRepository extends Repository implements SystemSettingRepositoryInterface
{
    public function __construct(SystemSetting $model)
    {
        $this->model = $model;
    }

    public function fetchSettings() 
    {
        return $this->model->all();
    }

    public function addSetting(array $data) 
    {
        return $this->create($data);
    }

    public function generateSystemCode(string $code = 'BJCDL_')
    {
        $max_code = $code . '001';
        if ($this->model) {
            $max_id = $this->model->max('id');
            if ($max_id) {
                $max_code = substr($max_code, 0, -strlen($max_id)) . '' . ($max_id + 1);
            }
        }
        return $max_code;
    }

    public function updateSetting(int $id, array $input, Object $data) 
    {
        $setting = $this->model->find($id);
        if ($setting->type == 'file') {
            $file_upload_path = $this->uploadFile($data->file('value'), $setting);
            $input['value'] = $file_upload_path;
        }
        if ($setting->type == 'toggle') {
            $input['value'] = isset($input['value']) ? 1 : 0;
            \Artisan::call('route:cache');
        }
        $setting->fill((array) $input)->save();
    }

    public function uploadFile(Object $file) 
    {
        $extension = $file->getClientOriginalExtension();
        $file_name = substr((pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)), 0, 30) . '-' . time() . '.' . $extension;
        $file_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', $file_name);
        $file_path = '/uploads/system_setting_images';
        $directory = public_path() . $file_path;

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0775);
        }

        $file->move($directory, $file_name);
        $file_upload_path = 'public' . $file_path . '/' . $file_name;
        return $file_upload_path;
    }
}
