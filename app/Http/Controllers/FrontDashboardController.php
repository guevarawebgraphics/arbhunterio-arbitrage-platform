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

        $games = $this->gamesPerMarketsV3([]);

        $oddsCache = [];

        if ($request->ajax()) {
            \Log::info('data table ajax');
            return datatables()->of($games)
                ->addColumn('id', function ($row) {
                    return '<div class="flex items-center">
                            <button data-modal-target="calculatorModal" data-modal-toggle="calculatorModal" class="bg-transparent outline-none" type="button" data-id="'.$row->uid.'">
                                <svg width="19" height="19" class="h-5 w-5 text-brand-purple" viewBox="0 0 14 20" fill="#B386D6" xmlns="http://www.w3.org/2000/svg"><path d="M1.39645 0.736376C0.961223 0.830673 0.685581 0.975748 0.428075 1.25139C0.239478 1.45449 0.141553 1.62495 0.058135 1.90785C0.00735898 2.08919 0.000105268 2.84721 0.000105268 9.99937C0.000105268 18.5769 -0.0107753 18.0329 0.188702 18.4282C0.355537 18.7582 0.798014 19.11 1.17883 19.2152C1.45085 19.2914 12.549 19.2914 12.821 19.2152C13.2019 19.11 13.6443 18.7582 13.8112 18.4282C14.0107 18.0329 13.9998 18.5769 13.9998 9.99937C13.9998 1.42548 14.0107 1.96588 13.8112 1.57418C13.6552 1.26227 13.249 0.924971 12.8827 0.794405C12.7268 0.740002 12.2371 0.732748 7.09061 0.729122C4.00053 0.725494 1.43634 0.729122 1.39645 0.736376ZM11.6423 3.51818C11.7112 3.54356 11.8019 3.6161 11.8491 3.68501C11.9288 3.8047 11.9325 3.83008 11.9325 4.74768C11.9325 5.57098 11.9252 5.70517 11.8708 5.79584C11.7366 6.02071 12.0159 6.00983 7.07248 6.00983C2.12907 6.00983 2.40834 6.02071 2.27415 5.79584C2.21974 5.70517 2.21249 5.57098 2.21249 4.74768C2.21249 3.83008 2.21612 3.8047 2.29591 3.68501C2.34306 3.6161 2.43373 3.54356 2.50264 3.51818C2.68398 3.45652 11.461 3.45652 11.6423 3.51818ZM3.9026 8.13517C4.1311 8.302 4.15286 8.36728 4.16374 8.89318C4.17462 9.31752 4.16737 9.39731 4.10208 9.54239C3.97514 9.82891 3.9026 9.8543 3.1192 9.8543C2.36844 9.8543 2.28865 9.83253 2.13995 9.59316C2.07104 9.48436 2.06741 9.4227 2.07467 8.92219C2.08555 8.30925 2.11094 8.24397 2.35756 8.10615C2.47 8.04449 2.55341 8.04087 3.14459 8.04812C3.74302 8.059 3.81193 8.06625 3.9026 8.13517ZM7.76158 8.1134C8.00095 8.23672 8.05173 8.38179 8.05173 8.95483C8.05173 9.50249 8.01184 9.62943 7.80148 9.77088C7.68542 9.85067 7.64552 9.8543 6.99994 9.8543C6.35436 9.8543 6.31447 9.85067 6.19841 9.77088C5.98805 9.62943 5.94815 9.50249 5.94815 8.95483C5.94815 8.38904 5.99893 8.23672 6.23105 8.11703C6.35073 8.05175 6.44141 8.04449 6.99269 8.04087C7.55122 8.04087 7.63464 8.04812 7.76158 8.1134ZM11.6423 8.10978C11.8889 8.24034 11.9143 8.30925 11.9252 8.92219C11.9325 9.4227 11.9288 9.48436 11.8599 9.59316C11.7112 9.83253 11.6314 9.8543 10.8807 9.8543C10.2714 9.8543 10.1988 9.84704 10.09 9.78176C9.89055 9.65845 9.82889 9.47348 9.82889 8.95846C9.82889 8.49422 9.85428 8.36728 9.98485 8.22584C10.1335 8.06625 10.2424 8.04449 10.8988 8.04087C11.432 8.04087 11.5335 8.05175 11.6423 8.10978ZM3.90986 11.6315C4.12384 11.762 4.17825 11.9542 4.16374 12.52C4.15286 13.0568 4.12747 13.1221 3.88084 13.2889C3.76841 13.3687 3.72489 13.3723 3.12283 13.3723C2.41922 13.3723 2.31041 13.347 2.16171 13.1439C2.0928 13.0532 2.08555 12.9806 2.07467 12.491C2.06741 11.9905 2.07104 11.9289 2.13995 11.8201C2.28865 11.5807 2.36844 11.5589 3.1192 11.5589C3.72852 11.5589 3.80105 11.5662 3.90986 11.6315ZM7.80148 11.6423C8.01184 11.7838 8.05173 11.9107 8.05173 12.4656C8.05173 12.9045 8.04085 12.9698 7.96831 13.0967C7.82687 13.3433 7.72894 13.3723 6.99994 13.3723C6.27094 13.3723 6.17302 13.3433 6.03157 13.0967C5.95903 12.9698 5.94815 12.9045 5.94815 12.4656C5.94815 11.9107 5.98805 11.7838 6.19841 11.6423C6.31447 11.5625 6.35436 11.5589 6.99994 11.5589C7.64552 11.5589 7.68542 11.5625 7.80148 11.6423ZM11.6713 11.6315C11.9071 11.7765 11.9361 11.8745 11.9252 12.491C11.9143 12.9806 11.9071 13.0532 11.8382 13.1439C11.6895 13.347 11.5807 13.3723 10.8771 13.3723C10.275 13.3723 10.2315 13.3687 10.119 13.2889C9.87241 13.1221 9.84702 13.0568 9.83614 12.52C9.82526 12.0957 9.83252 12.0159 9.8978 11.8708C10.0247 11.5843 10.0973 11.5589 10.8807 11.5589C11.4864 11.5589 11.5625 11.5662 11.6713 11.6315ZM3.9026 15.135C4.1311 15.3055 4.15286 15.3635 4.16374 15.9075C4.17825 16.4878 4.1456 16.6039 3.93162 16.7671L3.79743 16.8723H3.12283C2.38658 16.8723 2.31767 16.8578 2.15809 16.6438C2.0928 16.5567 2.08555 16.4806 2.07467 16.0018C2.06379 15.3635 2.09643 15.2619 2.36119 15.1205C2.51352 15.0407 2.54979 15.0371 3.16273 15.048C3.74302 15.0588 3.81193 15.0661 3.9026 15.135ZM11.6423 15.1241C11.9035 15.2619 11.9361 15.3635 11.9252 16.0018C11.9143 16.6003 11.8926 16.6655 11.6605 16.807C11.5589 16.8686 11.4102 16.8723 8.93306 16.8723C6.34711 16.8723 6.31447 16.8723 6.21654 16.7961C5.99167 16.6293 5.96629 16.5604 5.95541 16.0671C5.94815 15.8168 5.95178 15.5557 5.96629 15.4868C5.9953 15.3309 6.17664 15.1241 6.32535 15.0806C6.387 15.0625 7.55848 15.0443 8.96207 15.0443L11.4864 15.0407L11.6423 15.1241Z" fill="#    B386D6"></path></svg>
                            </button>
                        </div>';
                })
                ->addColumn('percent',  function ($row) {
                    $data = $this->getOdds($row);
                    return $data['profit_percentage'].'%';
                })
                ->addColumn('event_date', function ($row) {
                    return $this->formatEventDate($row->start_date);
                })
                ->addColumn('event', function ($row) {
                    return $this->formatEvent($row);
                })
                ->addColumn('market', function ($row) {
                    return $row->bet_type;
                })
                ->addColumn('bets', function ($row) {

                    $data = $this->getOdds($row);
                    $html = '<div class="flex flex-col">
                        <span>
                            '.$data['selection_line_a'].'
                        </span>
                        <span>
                            '.$data['selection_line_b'].'
                        </span>
                    </div>';

                    return $html;
                })
                ->addColumn('best_odds', function ($row) use (&$oddsCache) {
                    $data = $this->getOdds($row);
                    $html = '<div class="flex flex-col">
                        <div class="flex flex-row items-center gap-2">
                            <span>'.$data['best_odds_a'].'</span>
                        </div>
                        <div class="flex flex-row items-center gap-2">
                            <span>'.$data['best_odds_b'].'</span>
                        </div>
                    </div>';

                    return $html;

                })
                ->addColumn('books', function ($row) {
                    $data = $this->getOdds($row);
                    $html = '<div class="flex flex-col">
                            <div class="flex flex-row items-center gap-2">
                            '.$data['sportsbook_a'].'
                            </div>
                            <div class="flex flex-row items-center gap-2">
                             '.$data['sportsbook_b'].'
                            </div>
                        </div>';

                    return $html;
                })
                ->addColumn('updated', function ($row) {
                    return '';
                })
                ->rawColumns(['id','percent','event_date','event','market','bets','best_odds','books','updated'])->toJson();
        }


        return view('front.pages.dashboard.dashboard', compact('page','seo_meta'));
    }

    private function getOdds($row) {

        $best_odds_a = 0.00;
        $best_odds_b = 0.00;
        $selection_line_a = '';
        $selection_line_b = '';
        $sportsbook_a = '';
        $sportsbook_b = '';
        $counter = 0;

        $best_over_odds = GameOdds::where('bet_type', $row->bet_type)
                        ->where('game_id', $row->uid)
                        ->where('selection_line', 'over')
                        ->max('bet_price');

        $best_under_odds = GameOdds::where('bet_type', $row->bet_type)
                        ->where('game_id', $row->uid)
                        ->where('selection_line', 'under')
                        ->max('bet_price');

        $sports_book = getSportsBook();
    
        if ( !empty($best_over_odds) || !empty($best_under_odds) ) {
            
            $best_odds_a = convertAmericanToDecimalOdds($best_over_odds) ?? 0.00;
            $best_odds_b = convertAmericanToDecimalOdds($best_under_odds) ?? 0.00;
            $mergedOdds = GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->whereIn('selection_line', ['over','under'] )->get();
            
            $found_matched_over_under = $this->findMatchingBets($mergedOdds->toArray(), null, 1);
            $selection_line_a = isset($found_matched_over_under['over']['bet_name']) ? $found_matched_over_under['over']['bet_name'] : null;
            $selection_line_b = isset($found_matched_over_under['under']['bet_name']) ? $found_matched_over_under['under']['bet_name'] : null;

            $sportsbook_a_query = GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('bet_price', $best_over_odds)->where('selection_line', 'over')->distinct()->pluck('sportsbook');
            $sportsbook_b_query = GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('bet_price', $best_under_odds)->where('selection_line', 'under')->distinct()->pluck('sportsbook');

            $sportsbook_a = $this->sports_book_image($sportsbook_a_query, $sports_book);
            $sportsbook_b = $this->sports_book_image($sportsbook_b_query, $sports_book);

        } else {
            // Binary Wins
            $home_team = GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('selection','LIKE','%'.$row->home_team.'%')->max('bet_price');
            $away_team = GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('selection','LIKE','%'.$row->away_team.'%')->max('bet_price');
            $is_draw = GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('selection','Draw')->count();

            if ($is_draw > 0) {
            
                $best_odds_a = convertAmericanToDecimalOdds($home_team) ?? 0.00;
                $best_odds_b = convertAmericanToDecimalOdds($away_team) ?? 0.00;
                $selection_line_a = 'Draw';

            } else if ( !empty($home_team) || !empty($away_team) ) {
                // Binary
                
                $best_odds_a = convertAmericanToDecimalOdds($home_team) ?? 0.00;
                $best_odds_b = convertAmericanToDecimalOdds($away_team) ?? 0.00;
                
                $bet_name_query = $this->findBetName($row);
                $selection_line_a = $bet_name_query && $bet_name_query != "[]" ? $bet_name_query->TeamA_Bet_Name  :  $row->home_team;
                $selection_line_b = $bet_name_query && $bet_name_query != "[]" ? $bet_name_query->TeamB_Bet_Name  :  $row->away_team;

                $sportsbook_a_query = GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('bet_price', $home_team)->where('selection','LIKE','%'.$row->home_team.'%')->distinct()->pluck('sportsbook');
                $sportsbook_b_query = GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('bet_price', $away_team)->where('selection','LIKE','%'.$row->away_team.'%')->distinct()->pluck('sportsbook');

                $sportsbook_a = $this->sports_book_image($sportsbook_a_query, $sports_book);
                $sportsbook_b = $this->sports_book_image($sportsbook_b_query, $sports_book);


            } else {
            
                $query_yes = GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)
                            ->where('selection','yes')->max('bet_price');

                $query_no = GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)
                            ->where('selection','no')->max('bet_price');
            
                $query_odd  = GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)
                            ->where('selection','odd')->max('bet_price');

                $query_even = GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)
                            ->where('selection','even')->max('bet_price');
            


                // If Yes or No
                if ( !empty($query_yes) && !empty($query_no) ) {
                    $best_odds_a = convertAmericanToDecimalOdds($query_yes) ?? 0.00;
                    $best_odds_b = convertAmericanToDecimalOdds($query_no) ?? 0.00;
                    $selection_line_a = 'Yes';
                    $selection_line_b = 'No';

                    
                    $sportsbook_a_query = GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('selection','yes')->where('bet_price', $query_yes)->distinct()->pluck('sportsbook');
                    $sportsbook_b_query = GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('selection','no')->where('bet_price', $query_no)->distinct()->pluck('sportsbook');

                    $sportsbook_a = $this->sports_book_image($sportsbook_a_query, $sports_book);
                    $sportsbook_b = $this->sports_book_image($sportsbook_b_query, $sports_book);
                    
                } else if ( !empty($query_odd) && !empty($query_even) ) {
                    $best_odds_a = convertAmericanToDecimalOdds($query_odd) ?? 0.00;
                    $best_odds_b = convertAmericanToDecimalOdds($query_even) ?? 0.00;
                    $selection_line_a = 'Odd';
                    $selection_line_b = 'Even';
                    $sportsbook_a_query = GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('selection','odd')->where('bet_price', $query_odd)->distinct()->pluck('sportsbook');
                    $sportsbook_b_query = GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('selection','even')->where('bet_price', $query_even)->distinct()->pluck('sportsbook');

                    $sportsbook_a = $this->sports_book_image($sportsbook_a_query, $sports_book);
                    $sportsbook_b = $this->sports_book_image($sportsbook_b_query, $sports_book);
                }

            }
        }

        $profit_percentage = $this->calculateProfit($best_odds_a, $best_odds_b);

        $data = [
            'best_odds_a'   =>  $best_odds_a,
            'best_odds_b'   =>  $best_odds_b,
            'selection_line_a'   =>  $selection_line_a,
            'selection_line_b'   =>  $selection_line_b,
            'profit_percentage' =>  $profit_percentage,
            'sportsbook_a'  =>  $sportsbook_a,
            'sportsbook_b'  =>  $sportsbook_b
        ];

        return $data;

    }
    private function formatEventDate($date) {
        $dateTime = new DateTime($date);
        return $dateTime->format('D, M j  g:i A');
    }
    private function formatEvent($row) {
        return $row->home_team . ' vs ' . $row->away_team . '<div class="flex flex-row gap-2">
                <span><small>' . strtoupper($row->sport) . '</small></span>
                <span class="border-e"></span>
                <span><small>' . strtoupper($row->league) . '</small></span>
            </div>';
    }    

    private function findBetName($row) {
    
        $positiveMatches = function($query) use ($row) { // Add 'use ($row)'
            $query->from('gameodds AS A') 
                ->join('gameodds AS B', 'A.selection_points', '=', 'B.selection_points')
                ->where('A.selection', $row->home_team)
                ->where('B.selection', $row->away_team)
                ->where('A.selection_points', '>', 0)
                ->where('B.selection_points', '>', 0)
                ->where('A.game_id', $row->uid)
                ->where('B.game_id', $row->uid)
                ->where('A.bet_type', $row->bet_type)
                ->where('B.bet_type', $row->bet_type)
                ->select('A.selection_points');
        };


        $result = DB::table('gameodds AS A')
            ->join('gameodds AS B', function($join) {
                $join->on('A.selection_points', '=', DB::raw('-B.selection_points'));
            })
            ->where('A.game_id', $row->uid)
            ->where('B.game_id', $row->uid)
            ->where('A.bet_type', $row->bet_type)
            ->where('B.bet_type', $row->bet_type)
            ->whereNotExists($positiveMatches) 
            ->orderByDesc(DB::raw('ABS(A.selection_points)'))
            ->select(
                'A.selection AS TeamA_Name', 'A.bet_name AS TeamA_Bet_Name',
                'B.selection AS TeamB_Name', 'B.bet_name AS TeamB_Bet_Name'
            )
            ->first();

        // Assuming you want the home team to always have the higher selection point
        if ($result && $result->TeamA_Name != $row->home_team) {
            $swap = $result->TeamA_Name;
            $result->TeamA_Name = $result->TeamB_Name;
            $result->TeamB_Name = $swap;

            $swapBetName = $result->TeamA_Bet_Name;
            $result->TeamA_Bet_Name = $result->TeamB_Bet_Name;
            $result->TeamB_Bet_Name = $swapBetName;
        }
        
        return $result;
    }

    // private function findBetName($row) {
    //     $query = "
    //         WITH PositiveMatches AS (
    //             SELECT
    //                 A.selection_points
    //             FROM
    //                 (SELECT selection_points
    //                 FROM gameodds
    //                 WHERE selection = '".$row->away_team."'
    //                 AND selection_points > 0
    //                 AND game_id = '".$row->uid."'
    //                 AND bet_type = '".$row->bet_type."') AS A
    //             JOIN
    //                 (SELECT selection_points
    //                 FROM gameodds
    //                 WHERE selection = '".$row->home_team."'
    //                 AND selection_points > 0
    //                 AND game_id = '".$row->uid."'
    //                 AND bet_type = '".$row->bet_type."') AS B
    //             ON A.selection_points = B.selection_points
    //         )
    //         SELECT
    //             A.bet_name AS TeamA_Bet_Name,
    //             B.bet_name AS TeamB_Bet_Name
    //         FROM
    //             (SELECT bet_name, selection_points
    //             FROM gameodds
    //             WHERE selection = '".$row->away_team."'
    //             AND game_id = '".$row->uid."'
    //             AND bet_type = '".$row->bet_type."'
    //             ORDER BY selection_points DESC LIMIT 1) AS A
    //         JOIN
    //             (SELECT bet_name, selection_points
    //             FROM gameodds
    //             WHERE selection = '".$row->home_team."'
    //             AND game_id = '".$row->uid."'
    //             AND bet_type = '".$row->bet_type."'
    //             ORDER BY selection_points ASC LIMIT 1) AS B
    //         ON
    //             A.selection_points = -B.selection_points
    //         WHERE
    //             NOT EXISTS (SELECT 1 FROM PositiveMatches);
    //         ";

    //         $results = DB::select(DB::raw($query));
    //         return $results;
    // }


}
