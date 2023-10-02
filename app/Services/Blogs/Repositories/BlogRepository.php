<?php

namespace App\Services\Blogs\Repositories;

use App\Services\Base\Repository;
use App\Services\Blogs\Blog;
use File;

/**
 * Class BlogRepository
 * @package App\Services\Blogs\Repositories
 * @author Guevara Web Graphics Studio
 */

class BlogRepository extends Repository implements BlogRepositoryInterface
{
    public function __construct(Blog $model)
    {
        $this->model = $model;
    }

    public function fetchBlogs() 
    {
        return $this->model->all();
    }

    public function addBlog(array $data) 
    {
        return $this->create($data);
    }

    public function updateBlog(int $id, array $input, Object $data) 
    {
        $blog = $this->model->find($id);
        if ($data->hasFile('thumbnail')) {
            $file_upload_path = $this->uploadFile($data->file('thumbnail'), $blog);
            $input['thumbnail'] = $file_upload_path;
        }
        if ($data->hasFile('cover_image')) {
            $file_upload_path = $this->uploadFile($data->file('cover_image'), $blog);
            $input['cover_image'] = $file_upload_path;
        }
        $blog->fill((array) $input)->save();
    }

    public function uploadFile(Object $file) 
    {
        $extension = $file->getClientOriginalExtension();
        $file_name = substr((pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)), 0, 30) . '-' . time() . '.' . $extension;
        $file_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', $file_name);
        $file_path = '/uploads/blog_images';
        $directory = public_path() . $file_path;

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0775);
        }

        $file->move($directory, $file_name);
        $file_upload_path = 'public' . $file_path . '/' . $file_name;
        return $file_upload_path;
    }

    public function getBySlug(string $slug) 
    {
        $blog = $this->model->where('slug', $slug)->first();
        if ($blog) {
            return $blog;
        } else {
            abort('404', '404');
        }
    }

    public function getByCategory(int $id) 
    {
        $blogs = $this->model->where('blog_category_id', $id)->paginate(10);
        if ($blogs) {
            return $blogs;
        } else {
            abort('404', '404');
        }
    }
}
