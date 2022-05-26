<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Pages\Repositories\PageRepositoryInterface;

class OrderController extends Controller
{
    //

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function indexOrders(Request $request)
    {
        $page = $this->pageRepository->getPageBySlug('orders');
        if (!empty($page)) {
            $seo_meta = $this->getSeoMeta($page);
        }

        //$orders = $this->order_repository->getAllOrdersByUser();
        $orders = [];

        return view('front.pages.dashboard.orders', compact('page', 'orders'));
    }
}
