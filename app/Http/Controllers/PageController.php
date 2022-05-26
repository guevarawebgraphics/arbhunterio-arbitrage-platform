<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Pages\Repositories\PageRepositoryInterface;
use App\Http\Traits\SystemSettingTrait;

class PageController extends Controller
{
    use SystemSettingTrait;
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * Show the application home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('front.pages.home');
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function showPages($slug = '')
    {
        $page = $seo_meta = [];
        if ($slug == '') {
            /* home */
            $page = $this->pageRepository->getPageBySlug('home');
            if (empty($page)) {
                return view('front.pages.view-handler');
            } else {
                $seo_meta = $this->getSeoMeta($page);
            }
        } else {
            $page = $this->pageRepository->getPageBySlug($slug);
            /* if not in pages */
            if (empty($page)) {
                abort('404', '404');
            } else {
                $seo_meta = $this->getSeoMeta($page);
            }
        }
        return view('front.pages.view-handler', compact('page', 'seo_meta'));
    }
}
