<?php

namespace App\Http\Controllers;

use App\Http\Traits\SystemSettingTrait;
use App\Services\Pages\Repositories\PageRepositoryInterface;
use Illuminate\Http\Request;
use App\Services\OddsJamGameEventCronJobs\OddsJamGameEventCronJob;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Traits\OddsJamAPITrait;
use App\Services\GameOdds\GameOdds;

use DateTime;
use DateTimeZone;
use DB;


/**
 * Class DashboardController
 * @package App\Http\Controllers
 * @author Guevara Web Graphics Studio
 */
class FrontDashboardController extends Controller
{

    use SystemSettingTrait, OddsJamAPITrait;

    /**
     * @param PageRepositoryInterface
     * @param ProductRepository 
     */
    private $order_repository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index( Request $request )
    {
        $page = $this->pageRepository->getPageBySlug('dashboard');
        
        $seo_meta = $this->getSeoMeta($page);

        return view('front.pages.dashboard.dashboard', compact('page','seo_meta'));
    }


    public function indexBetConversion( Request $request ) {

        $page = $this->pageRepository->getPageBySlug('bet_conversion');
        
        $seo_meta = $this->getSeoMeta($page);

        return view('front.pages.dashboard.calculators.bet_conversion', compact('page','seo_meta'));
    }

    public function indexArbitrageHedgeCalculator( Request $request ) {

        $page = $this->pageRepository->getPageBySlug('arbitrage_hedge_calculator');
        
        $seo_meta = $this->getSeoMeta($page);

        return view('front.pages.dashboard.calculators.arbitrage', compact('page','seo_meta'));
    }

    public function indexBetTracker( Request $request  ) {
        
        $page = $this->pageRepository->getPageBySlug('bet-tracker');
        
        $seo_meta = $this->getSeoMeta($page);

        return view('front.pages.dashboard.bet_tracker', compact('page','seo_meta'));
    }
}
