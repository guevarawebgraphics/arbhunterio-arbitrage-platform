<?php

namespace App\Services\GalleryImages\Repositories;

use App\Services\Base\Repository;
use App\Services\GalleryImages\GalleryImage;
use File;

/**
 * Class GalleryGroupRepository
 * @package App\Services\GalleryImages\Repositories
 * @author Bryan James Dela Luya
 */

class GalleryImageRepository extends Repository implements GalleryImageRepositoryInterface
{
    public function __construct(GalleryImage $model)
    {
        $this->model = $model;
    }

    public function fetchGalleryImages() 
    {
        return $this->model->all();
    }

    public function addGalleryImage(array $data) 
    {
        return $this->create($data);
    }

    public function updateGalleryImage(int $id, array $input, Object $data) 
    {
        $gallery = $this->model->find($id);
        if ($data->hasFile('background_image')) {
            $file_upload_path = $this->uploadFile($data->file('background_image'), $gallery);
            $input['background_image'] = $file_upload_path;
        }
        $gallery->fill((array) $input)->save();
    }

    public function uploadFile(Object $file) 
    {
        $extension = $file->getClientOriginalExtension();
        $file_name = substr((pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)), 0, 30) . '-' . time() . '.' . $extension;
        $file_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', $file_name);
        $file_path = '/uploads/gallery_images';
        $directory = public_path() . $file_path;

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0775);
        }

        $file->move($directory, $file_name);
        $file_upload_path = 'public' . $file_path . '/' . $file_name;
        return $file_upload_path;
    }
}
