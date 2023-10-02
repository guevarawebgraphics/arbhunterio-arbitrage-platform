<?php

namespace App\Services\Products\Repositories;

use App\Services\Base\Repository;
use App\Services\Products\Product;
use File;

/**
 * Class ProductRepository
 * @package App\Services\Products\Repositories
 * @author Guevara Web Graphics Studio
 */

class ProductRepository extends Repository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }

    public function addProduct(array $data) 
    {
        return $this->create($data);
    }

    function updateProduct(int $id, array $input) 
    {
        $data = $this->model->find($id);
        $data->fill($input)->save();
    }

    public function uploadFile(Object $file) 
    {
        $extension = $file->getClientOriginalExtension();
        $file_name = substr((pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)), 0, 30) . '-' . time() . '.' . $extension;
        $file_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', $file_name);
        $file_path = '/uploads/product_images';
        $directory = public_path() . $file_path;

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0775);
        }

        $file->move($directory, $file_name);
        $file_upload_path = 'public' . $file_path . '/' . $file_name;
        return $file_upload_path;
    }

    public function galleryUpload(int $id, Object $request)
    {
        \DB::beginTransaction();

        try {

            $data = $this->model->find($id);

            # save gallery uploads
            foreach($request->file('images') as $image) 
                $data->attach($image, 'product_gallery');
            
            \DB::commit();

            return $data;

        } catch (\Exception $e) {
            \Log::error('admin.products.gallery.upload');
            \Log::error($e->getMessage());

            \DB::rollback();

            return false;
        }
    }

    public function galleryUploadOnCreate(int $id, Object $request)
    {
        \DB::beginTransaction();

        try {

            $data = $this->model->find($id);

            # save gallery uploads
            foreach($request->file('images') as $image) 
                $data->attach($image, 'product_gallery');
            
            \DB::commit();

            return $data;

        } catch (\Exception $e) {
            \Log::error('admin.products.gallery.upload');
            \Log::error($e->getMessage());

            \DB::rollback();

            return false;
        }
    }

    /**
     * Delete gallery item
     */
    public function galleryDelete(int $id, Object $request)
    {
        \DB::beginTransaction();
        
        try {
            
            $data = $this->model->find($id);

            $attachment = $data->gallery->where('id', $request->id)->first();
            
            $attachment->delete();

            \DB::commit();

            return true;

        } catch (\Exception $e) {
            \Log::error('admin.products.gallery.delete');
            \Log::error($e->getMessage());

            \DB::rollback();

            return false;
        }
    }
}
