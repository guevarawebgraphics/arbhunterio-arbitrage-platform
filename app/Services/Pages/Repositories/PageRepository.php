<?php

namespace App\Services\Pages\Repositories;

use App\Services\Base\Repository;
use App\Services\Pages\Page;
use Illuminate\Filesystem\Filesystem;
use File;

/**
 * Class PageRepository
 * @package App\Services\Pages\Repositories
 * @author Bryan James Dela Luya
 */

class PageRepository extends Repository implements PageRepositoryInterface
{
    public function __construct(Page $model, Filesystem $fileSystem)
    {
        $this->model = $model;
        $this->fileSystem = $fileSystem;
    }

    public function fetchPages() 
    {
        return $this->model->all();
    }

    public function addPage(array $data) 
    {
        $page = $this->create($data);
        $page->is_active = $data['is_active'];
        $page->fill($data)->save();

        $directory = 'resources/views/front/pages/dynamic/';
        $template = $this->fileSystem->get(storage_path('bjcdl/automated_pages/generate_page.blade.php'));
        $template = $this->replaceTexts($data['name'], $template);
        $this->fileSystem->put($directory . $data['slug'] . '.blade.php', $template);
        return $page;
    }

    public function updatePage(int $id, array $data) 
    {
        $old = $this->model->find($id);
        $page = $this->model->find($id);
        $page->is_active = $data['is_active'];
        $page->fill($data)->save();

        File::move(resource_path('views/front/pages/dynamic/' . $old['slug'] . '.blade.php'), resource_path('views/front/pages/dynamic/' . $page['slug'] . '.blade.php'));

        return $page;
    }

    public function getPageBySlug($slug)
    {
        return $this->model->where('is_active', 1)->where('slug', $slug)->first();
    }

    public function replaceTexts($data, $template)
    {
        $template = str_replace("BJCDL_GENERATE_VIEW", $data, $template);

        return $template;
    }

    public function pluckNames()
    {
        return $this->model->pluck('name','name')->all();
    }

    public function getIdByName(string $name) 
    {
        $page = $this->model->where('name', $name)->first();
        return ($page->id ? $page->id : 0);
    }

    public function getNameById(int $id)
    {
        $page = $this->model->find($id);
        return ($page ? $page->name : 0);
    }
}