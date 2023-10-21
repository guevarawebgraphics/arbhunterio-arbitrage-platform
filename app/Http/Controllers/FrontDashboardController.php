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

use DateTime;
use DateTimeZone;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 * @author Guevara Web Graphics Studio
 */
class FrontDashboardController extends Controller
{

    use SystemSettingTrait, OddsJamAPITrait;

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

    public function index( Request $request )
    {
        $page = $this->pageRepository->getPageBySlug('dashboard');
        
        $seo_meta = $this->getSeoMeta($page);

        // $games = $this->gamesPerMarkets([]);

        // if ($request->ajax()) {
        //     return datatables()->of($games)
        //         ->addColumn('id', function ($row) {
        //             $html = '';
        //             return $html;
        //         })
        //         ->addColumn('percent', function ($row) {
        //             $html = $row['profit_percentage']. '%';
        //             return $html;
        //         })
        //         ->addColumn('event_date', function ($row) {
        //             $html = $row['formattedDate'];
        //             return $html;
        //         })
        //         ->addColumn('event', function ($row) {
        //             $html = $row['home_team'] . ' vs ' . $row['home_team'];
        //             $html .= '<div class="flex flex-row gap-2">
        //                         <span>'.$row['sports'].'</span>
        //                         <span class="border-e"></span>
        //                         <span>'.$row['league'].'</span>
        //                     </div>';
        //             return $html;
        //         })
        //         ->addColumn('market', function ($row) {
        //             $html = $row['market'];
        //             return $html;
        //         })
        //        ->addColumn('bets', function ($row) {
        //             $html = '<div class="flex flex-col">
        //                 <div class="flex flex-row items-center gap-2">
        //                     <span>'.$row['selection_line']['over'].'</span>
        //                 </div>
        //                 <div class="flex flex-row items-center gap-2">
        //                     <span>'.$row['selection_line']['under'].'</span>
        //                 </div>
        //             </div>';
        //             return $html;
        //         })
        //         ->addColumn('best_odds', function ($row) {
        //              $html = '<div class="flex flex-col">
        //                 <div class="flex flex-row items-center gap-2">
        //                     <span>'.$row['best_odds']['over'].'</span>
        //                 </div>
        //                 <div class="flex flex-row items-center gap-2">
        //                     <span>'.$row['best_odds']['under'].'</span>
        //                 </div>
        //             </div>';
        //             return $html;
        //         })
        //         ->addColumn('books', function ($row) {
        //             $html = '<div class="flex flex-col">
        //                         <div class="flex flex-row items-center gap-2">
        //                           '.$row['sports_book']['over'].'
        //                         </div>
        //                         <div class="flex flex-row items-center gap-2">
        //                             '.$row['sports_book']['under'].'
        //                         </div>
        //                     </div>';
        //             return $html;
        //         })
        //         ->addColumn('updated', function ($row) {
        //             $html = '';
        //             return $html;
        //         })->rawColumns(['id','percent','event_date','event','market','bets','best_odds','books','updated'])->toJson();
        // }

        return view('front.pages.dashboard.dashboard', compact('page','seo_meta'));
    }
}
