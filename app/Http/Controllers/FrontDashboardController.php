<?php

namespace App\Http\Controllers;

use App\Http\Traits\SystemSettingTrait;
use App\Services\Pages\Repositories\PageRepositoryInterface;
// use App\Repositories\ProductRepository;
// use App\Repositories\OrderRepository;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 * @author Guevara Web Graphics Studio
 */
class FrontDashboardController extends Controller
{

    use SystemSettingTrait;

    /**
     * @param PageRepositoryInterface $pageRepository
     * @param ProductRepository $product_repository
     */
    private $order_repository;

    public function __construct(PageRepositoryInterface $pageRepository /*, ProductRepository $product_repository,OrderRepository $order_repository*/)
    {
        $this->pageRepository = $pageRepository;
        // $this->product_repository = $product_repository;
        // $this->order_repository = $order_repository;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $page = $this->pageRepository->getPageBySlug('dashboard');
        
        $seo_meta = $this->getSeoMeta($page);

        return view('front.pages.dashboard.dashboard', compact('page','seo_meta'));
    }
}
