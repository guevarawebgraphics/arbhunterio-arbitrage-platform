<?php


/**
 * @param null $title
 * @param null $message
 * @return \Illuminate\Foundation\Application|mixed
 * For the flash messages.
 */
function custom_flash($title = null, $message = null) {
    // Set variable $flash to fetch the Flash Class
    // in Flash.php
    $flash = app('App\Http\Flash');

    // If 0 parameters are passed in ($title, $message)
    // then just return the flash instance.
    if (func_num_args() == 0) {
        return $flash;
    }

    // Just return a regular flash->info message
    return $flash->info($title, $message);
}

/**
 * For highlighting of words that matched the keywords.
 *
 * @param null $text
 * @param null $words
 *
 * @return \Illuminate\Foundation\Application|mixed
 */
function highlight_word($text = null, $words = null)
{
    return preg_replace("/\w*?" . preg_quote($text) . "\w*/i", "<b><i>$0</i></b>", $words);
}

/**
 * For highlighting of keywords only.
 *
 * @param null $text
 * @param null $words
 *
 * @return \Illuminate\Foundation\Application|mixed
 */
function highlight_keyword($text = null, $words = null)
{
    $replace = '<b><i>' . $text . '</i></b>';
    $words = str_ireplace($text, $replace, $words);
    return $words;
}

/**
 * @param null string $url
 *
 * @return \Illuminate\Foundation\Application|mixed
 * Add http to url
 */
function add_http($url = null)
{
    if ($url) {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
    }
    return $url;
}

//Global Functions
function CleanUrl($string) {
    $string = strtolower($string);
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    $string = preg_replace("/[\s-]+/", " ", $string);
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}

function getSystemSetting($code) {
    $system = \App\Services\SystemSettings\SystemSetting::where('code', $code)->first();
    return $system;
}

function section($parameters, \App\Services\Pages\Page $page = null) {    
    $sections = collect([]);
    if (!empty($page))
        $sections = $page->sections;

    $repository = new \App\Services\Sections\Repositories\SectionDisplayHandler($sections);

    return $repository->render($parameters);
}

function getAttachment($id){
    $image = \App\Services\Attachments\Attachment::find($id);
    return $image;
}

function addSection($name, $type, $pages, $value = '') {
    if (empty($value) && $type === \App\Services\Sections\Section::FORM)
        $value = '{"options": {}, "fields": [], "data": []}';

    $section = \App\Services\Sections\Section::create(compact('name', 'type', 'value'));
    $section->pages()->sync($pages);

    return $section;
}

function gallery($name) {
    $gallery_group = \App\Services\GalleryGroups\GalleryGroup::where('name', $name)->first();
    return \App\Services\GalleryImages\GalleryImage::where('gallery_group_id', $gallery_group->id)->get();
}

function blogs() {
    return \App\Services\Blogs\Blog::where('is_active', 1)->paginate(10);
}

function blogsCategories() {
    return \App\Services\BlogCategories\BlogCategory::get();
}

function featuredBlogs() {
    return \App\Services\Blogs\Blog::where('is_featured', 1)->get();
}

function menu() {
    return \App\Services\Menus\Menu::where('is_active', 1)->orderBy('order_number')->get();
}

function dropdown($menu) {
    return \App\Services\MenuDropdowns\MenuDropdown::where('is_active', 1)->where('menu_id', $menu->id)->orderBy('order_number')->get();
}

function getSportsBook() {
    return \App\Services\SportsBooks\SportsBook::where('is_active', 1)->whereNull('deleted_at')->orderBy('id','ASC')->get();
}

function getSports() {
    $data = [
        'football',
        'basketball',
        'baseball',
        'mma',
        'boxing',
        'hockey',
        'soccer',
        'tennis',
        'golf',
        'motorsports',
        'esports',
        'wrestling',
        'aussie-rules',
        'rugby'
    ];

    return $data;
}

function convertAmericanToDecimalOdds(int $americanOdds = NULL): float
{
    $formula = 0.00;
    if ($americanOdds > 0) {
        $formula = 1 + ($americanOdds / 100);
    }

    if ($americanOdds < 0) {
         $formula = 1 - (100 / $americanOdds);
    }
    return number_format($formula, 2, '.', '');
}

function getOdds($row) {

    $best_odds_a = 0.00;
    $best_odds_b = 0.00;
    $selection_line_a = '';
    $selection_line_b = '';
    $sportsbook_a = '';
    $sportsbook_b = '';
    $counter = 0;
    $sports_book = getSportsBook();

    $best_over_odds_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)
        ->where('game_id', $row->uid)
        ->where('selection_line', 'over')
        ->where('is_live', 0)
        ->where('is_main', 0)
        ->orderByRaw("timestamp DESC")
        ->first();

    $best_under_odds_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)
        ->where('game_id', $row->uid)
        ->where('selection_line', 'under')
        ->where('is_live', 0)
        ->where('is_main', 0)
        ->orderByRaw("timestamp DESC")
        ->first();

    $best_over_odds = $best_over_odds_query->bet_price ?? 0.00;
    $best_under_odds = $best_under_odds_query->bet_price ?? 0.00;

    if ( !empty($best_over_odds) || !empty($best_under_odds) ) {

        $selection_line_a_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)
            ->where('game_id', $row->uid)
            ->where('selection_line','over')
            ->where('is_live', 0)
            ->where('is_main', 0)
            ->orderByRaw("selection_points DESC")
            ->first();

        $selection_line_b_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)
            ->where('game_id', $row->uid)
            ->where('selection_line','under')
            ->where('is_live', 0)
            ->where('is_main', 0)
            ->orderByRaw("selection_points DESC")
            ->first();

        $sportsbook_a_query = getLatestSportsBookBet([
            'row'   =>  $row,
            'type'  =>  'over',
            'exclude'   =>  null,
        ]);

        $sportsbook_b_query = getLatestSportsBookBet([
            'row'   =>  $row,
            'type'  =>  'under',
            'exclude'   =>  $sportsbook_a_query['sportsbook'],
        ]);


        $latest_betname_a = getLatestBetName([
            'row'   =>  $row,
            'type'  =>  'over'
        ]);

        $latest_betname_b = getLatestBetName([
            'row'   =>  $row,
            'type'  =>  'under'
        ]);

        $matched_bet_name = getMatchedBetName($latest_betname_a, $latest_betname_b);

        $sportsbook_a = sports_book_image($sportsbook_a_query['sportsbook'], $sports_book);
        $sportsbook_b = sports_book_image($sportsbook_b_query['sportsbook'], $sports_book);

        $best_odds_a = convertAmericanToDecimalOdds($best_over_odds) ?? 0.00;
        $best_odds_b = convertAmericanToDecimalOdds($best_under_odds) ?? 0.00;

        
        $selection_line_a = $matched_bet_name['over']['bet_name'] ?? '';
        $selection_line_b = $matched_bet_name['under']['bet_name'] ?? '';
        


    } else {

        $home_team_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)
            ->where('game_id', $row->uid)
            ->where('selection', $row->home_team )
            ->where('is_live', 0)
            ->where('is_main', 0)
            ->orderByRaw("timestamp DESC")
            ->first();

        $away_team_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)
            ->where('game_id', $row->uid)
            ->where('selection', $row->away_team )
            ->where('is_live', 0)
            ->where('is_main', 0)
            ->orderByRaw("timestamp DESC")
            ->first();

        $home_team = $home_team_query->bet_price ?? 0.00;
        $away_team = $away_team_query->bet_price ?? 0.00;

        $is_draw = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('selection','Draw')->count();

        if ($is_draw > 0) {
        
            $best_odds_a = convertAmericanToDecimalOdds($home_team) ?? 0.00;
            $best_odds_b = convertAmericanToDecimalOdds($away_team) ?? 0.00;
            $selection_line_a = 'Draw';

        } else if ( !empty($home_team) || !empty($away_team) ) {
            // Binary
            
            $best_odds_a = convertAmericanToDecimalOdds($home_team) ?? 0.00;
            $best_odds_b = convertAmericanToDecimalOdds($away_team) ?? 0.00;
            
            // $bet_name_query = findBetName($row);
            // $selection_line_a = $bet_name_query && $bet_name_query != "[]" ? $bet_name_query->TeamA_Bet_Name  :  '--';
            // $selection_line_b = $bet_name_query && $bet_name_query != "[]" ? $bet_name_query->TeamB_Bet_Name  :  '--';

            $selection_line_a_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)
                ->where('game_id', $row->uid)
                ->where('selection',$row->home_team)
                ->where('is_live', 0)
                ->where('is_main', 0)
                ->orderByRaw("timestamp DESC, selection_points DESC")
                ->first();

            $selection_line_b_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)
                ->where('game_id', $row->uid)
                ->where('selection',$row->away_team)
                ->where('is_live', 0)
                ->where('is_main', 0)
                ->orderByRaw("timestamp DESC, selection_points DESC")
                ->first();

            $selection_line_a = $selection_line_a_query->bet_name ?? '';
            $selection_line_b = $selection_line_b_query->bet_name ?? '';

            $sportsbook_a_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)
                ->where('game_id', $row->uid)
                ->where('bet_price', $home_team)
                ->where('selection',$row->home_team)
                ->distinct()
                ->pluck('sportsbook');

            $sportsbook_b_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)
                ->where('game_id', $row->uid)
                ->where('bet_price', $away_team)
                ->where('selection',$row->away_team)
                ->whereNotIn('sportsbook', $sportsbook_a_query)
                ->distinct()
                ->pluck('sportsbook');


            $sportsbook_a = sports_book_image($sportsbook_a_query, $sports_book);
            $sportsbook_b = sports_book_image($sportsbook_b_query, $sports_book);

        } else {
        
            $query_yes_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)
                        ->where('selection','yes')
                        ->orderByRaw("timestamp DESC")
                        ->first();
                        // ->max('bet_price');

            $query_no_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)
                        ->where('selection','no')
                        ->orderByRaw("timestamp DESC")
                        ->first();
                        // ->max('bet_price');
        
            $query_odd_query  = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)
                        ->where('selection','odd')
                        ->orderByRaw("timestamp DESC")
                        ->first();
                        // ->max('bet_price');

            $query_even_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)
                        ->where('selection','even')
                        ->orderByRaw("timestamp DESC")
                        ->first();
                        // ->max('bet_price');

            $query_yes = $query_yes_query ? $query_yes_query->bet_price : 0.00;
            $query_no = $query_no_query ? $query_no_query->bet_price : 0.00;
        
            $query_odd = $query_odd_query ? $query_odd_query->bet_price : 0.00;
            $query_even = $query_even_query ? $query_even_query->bet_price : 0.00;

            // If Yes or No
            if ( !empty($query_yes) && !empty($query_no) ) {
                $best_odds_a = convertAmericanToDecimalOdds($query_yes) ?? 0.00;
                $best_odds_b = convertAmericanToDecimalOdds($query_no) ?? 0.00;
                $selection_line_a = 'Yes';
                $selection_line_b = 'No';

                
                $sportsbook_a_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)
                    ->where('game_id', $row->uid)
                    ->where('selection','yes')
                    ->where('bet_price', $query_yes)
                    ->distinct()
                    ->pluck('sportsbook');

                $sportsbook_b_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)
                    ->where('game_id', $row->uid)
                    ->where('selection','no')
                    ->where('bet_price', $query_no)
                    ->whereNotIn('sportsbook', $sportsbook_a_query)
                    ->distinct()
                    ->pluck('sportsbook');

                $sportsbook_a = sports_book_image($sportsbook_a_query, $sports_book);
                $sportsbook_b = sports_book_image($sportsbook_b_query, $sports_book);
                
            } else if ( !empty($query_odd) && !empty($query_even) ) {
                
                $best_odds_a = convertAmericanToDecimalOdds($query_odd) ?? 0.00;
                $best_odds_b = convertAmericanToDecimalOdds($query_even) ?? 0.00;
                $selection_line_a = 'Odd';
                $selection_line_b = 'Even';
                $sportsbook_a_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)
                    ->where('game_id', $row->uid)
                    ->where('selection','odd')
                    ->where('bet_price', $query_odd)
                    ->distinct()
                    ->pluck('sportsbook');

                $sportsbook_b_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)
                    ->where('game_id', $row->uid)
                    ->where('selection','even')
                    ->where('bet_price', $query_even)
                    ->whereNotIn('sportsbook', $sportsbook_a_query)
                    ->distinct()
                    ->pluck('sportsbook');

                $sportsbook_a = sports_book_image($sportsbook_a_query, $sports_book);
                $sportsbook_b = sports_book_image($sportsbook_b_query, $sports_book);
            }

        }
    }

    $profit_percentage = calculateProfit($best_odds_a, $best_odds_b);

    if ($selection_line_a && $selection_line_b) {
        $data = [
            'best_odds_a'   =>  $best_odds_a,
            'best_odds_b'   =>  $best_odds_b,
            'selection_line_a'   =>  $selection_line_a,
            'selection_line_b'   =>  $selection_line_b,
            'profit_percentage' =>  $profit_percentage,
            'sportsbook_a'  =>  $sportsbook_a,
            'sportsbook_b'  =>  $sportsbook_b
        ];
    } else {
        $data = [
            'best_odds_a'   =>  0,
            'best_odds_b'   =>  0,
            'selection_line_a'   =>  '',
            'selection_line_b'   =>  '',
            'profit_percentage' =>  0,
            'sportsbook_a'  =>  '',
            'sportsbook_b'  =>  ''
        ];
    }
    return $data;

}

function formatEventDate($date) {
    $dateTime = new DateTime($date);
    return $dateTime->format('D, M j  g:i A');
}

function formatEvent($row) {
    return $row->home_team . ' vs ' . $row->away_team . '<div class="flex flex-row gap-2">
            <span><small>' . strtoupper($row->sport) . '</small></span>
            <span class="border-e"></span>
            <span><small>' . strtoupper($row->league) . '</small></span>
        </div>';
}   

function findBetName($row) {

    $positiveMatches = function($query) use ($row) {
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

function findMatchingBets($dataObj1, $dataObj2, $type) {
        
    if ($type == 1) {

        // Convert the object to an array.
        $dataArray = array_values($dataObj1);

        $overs = array_filter($dataArray, function($item) {
            return $item['selection_line'] === "over";
        });

        $unders = array_filter($dataArray, function($item) {
            return $item['selection_line'] === "under";
        });

        $matchingPairs = [];

        foreach ($overs as $over) {
            foreach ($unders as $under) {
                if (abs($over['selection_points']) === abs($under['selection_points'])) {
                    $matchingPairs[] = ['over' => $over, 'under' => $under];
                }
            }
        }

        if (count($matchingPairs) === 0) {
            return null;
        }

        $highestSelectionPoint = max(array_map(function($pair) {
            return abs($pair['over']['selection_points']);
        }, $matchingPairs));

        $highestPair = array_filter($matchingPairs, function($pair) use ($highestSelectionPoint) {
            return abs($pair['over']['selection_points']) === $highestSelectionPoint;
        });

        return array_values($highestPair)[0];

    } elseif ($type == 2 && $dataObj1 && $dataObj2) {


        // Convert the object to an array.
        $dataArray1 = array_values($dataObj1);
        $dataArray2 = array_values($dataObj2);

        $homes = array_filter($dataArray1, function($item) {
            return $item['selection_line'] != "over" && $item['selection_line'] != "under";
        });

        $aways = array_filter($dataArray2, function($item) {
            return $item['selection_line'] != "over" && $item['selection_line'] != "under";
        });

        $matchingPairs = [];

        foreach ($homes as $home) {
            $matched = false;


            if ($home['selection_points'] > 0) {
                foreach ($aways as $away) {
                    
                    if ($home['selection_points'] === -$away['selection_points']) {
                        $matchingPairs[] = ['home' => $home, 'away' => $away];
                        
                        $matched = true;
                        break;
                    }
                }
            }

            if (!$matched && $home['selection_points'] < 0) {
                foreach ($aways as $away) {
                    if (-$home['selection_points'] === $away['selection_points']) {
                        $matchingPairs[] = ['home' => $home, 'away' => $away];
                        \Log::info('Inside' . json_encode($matchingPairs));
                        break;
                    }
                }
            }
        }

        if (count($matchingPairs) === 0) {
            return null;
        }

        $highestSelectionPoint = max(array_map(function($pair) {
            return abs($pair['home']['selection_points']);
        }, $matchingPairs));

        $highestPair = array_filter($matchingPairs, function($pair) use ($highestSelectionPoint) {
            return abs($pair['home']['selection_points']) === $highestSelectionPoint;
        });

        return array_values($highestPair)[0];
    }
}

function sports_book_image($arr, $sports_book) {
    $imagesHTML = '';
    
    // Convert Eloquent Collection to array
    $sports_book_array = $sports_book->toArray();
    
    if (count($arr) > 0) {
        foreach ($arr as $name) {
            if ($name != '') {
                $book = array_filter($sports_book_array, function($item) use ($name) {
                    return $item['name'] === $name;
                });

                // Using current() to get the first item from the filtered array.
                $book = current($book);

                if ($book) {
                    $imagesHTML .= '<img class="rounded" width="24" src="' . url($book['image_url']) . '" />';
                }
            }
        }
    }
    return $imagesHTML;
}

function calculateProfit($oddsA, $oddsB) {
    // Convert the input values to float
    $odds1 = floatval($oddsA);
    $odds2 = floatval($oddsB);

    // $odds1 = floatval(1.44);
    // $odds2 = floatval(3.7);
    
    // Check for division by zero
    if ($odds1 == 0 || $odds2 == 0) {
        return 0;
    }

    // Calculate the profit percentage
    $profitPercentage = (1 - (1 / $odds1 + 1 / $odds2)) * 100;

    // Return the result rounded to two decimal places
    return number_format(abs($profitPercentage),2,'.',',');
}

function getLatestSportsBookBet($data) {
    $gameId = $data['row']['uid'];
    $betType = $data['row']['bet_type'];
    $isLive = 0;
    $isMain = 0;
    $selectionLine = $data['type'];
    $exluded = $data['exclude'];

    $subQuery = \App\Services\GameOdds\GameOdds::select('sportsbook', DB::raw('MAX(timestamp) as max_timestamp'))
        ->where('game_id', $gameId)
        ->where('bet_type', $betType)
        ->where('is_live', $isLive)
        ->where('is_main', $isMain)
        ->where('selection_line', $selectionLine)
        ->groupBy('sportsbook');

    $results = \App\Services\GameOdds\GameOdds::select([
        'gameodds.bet_name', 
        \DB::raw('FROM_UNIXTIME(gameodds.timestamp, "%m/%d/%Y %h:%i:%s %p") as formatted_time'), 
        'gameodds.sportsbook',
        'gameodds.selection_points',
        'gameodds.bet_price'
    ])
    ->joinSub($subQuery, 'sub', function ($join) use($exluded) {
        $join->on('gameodds.sportsbook', '=', 'sub.sportsbook')
        ->whereRaw('gameodds.timestamp = sub.max_timestamp');

        if ($exluded) {
            $join->whereNotIn('gameodds.sportsbook', $exluded );
        }
    })
    ->where('game_id', $gameId)
    ->where('bet_type', $betType)
    ->where('is_live', $isLive)
    ->where('is_main', $isMain)
    ->where('selection_line', $selectionLine)
    ->orderBy('gameodds.sportsbook')
    ->orderByDesc('gameodds.timestamp')
    ->get();

    $array = [];

    foreach ($results as $result) {
        $sub_array = [
            'bet_name'  =>  $result->bet_name,
            'formatted_time'  =>  $result->formatted_time,
            'sportsbook'  =>  $result->sportsbook,
            'selection_points'  =>  $result->selection_points,
            'bet_price' =>  $result->bet_price
        ];
        array_push($array, $sub_array);
    }

    $latest_sb_bet = $array;

    if (is_array($latest_sb_bet)) {
        // Extract bet_price values into a separate array
        $bet_prices = array_column($latest_sb_bet, 'bet_price');
        
        // Check if there are any bet prices
        if (count($bet_prices) > 0) {
            // Find the highest bet_price
            $highestPrice = max($bet_prices);

            // Collect all sportsbooks with the highest bet_price
            $highestPriceSportsbooks = array_filter($latest_sb_bet, function ($bet) use ($highestPrice) {
                return $bet['bet_price'] == $highestPrice;
            });

            // Extract the sportsbook names
            $sportsbookNames = array_column($highestPriceSportsbooks, 'sportsbook');

            // If you want to see the unique sportsbook names only, use array_unique
            $uniqueSportsbookNames = array_unique($sportsbookNames);
            $unique_data = [
                'sportsbook'    =>  $uniqueSportsbookNames
            ];

        } else {
            $unique_data = [
                'sportsbook'    =>  []
            ];

        }
    } else {
       $unique_data = [
            'sportsbook'    =>  []
        ];

    }

    return $unique_data;
}

function getLatestBetName($data) {
    $gameId = $data['row']['uid'];
    $betType = $data['row']['bet_type'];
    $isLive = 0;
    $isMain = 0;
    $selectionLine = $data['type'];
    
    $subQuery = \App\Services\GameOdds\GameOdds::select('sportsbook', DB::raw('MAX(timestamp) as max_timestamp'))
        ->where('game_id', $gameId)
        ->where('bet_type', $betType)
        ->where('is_live', $isLive)
        ->where('is_main', $isMain)
        ->where('selection_line', $selectionLine)
        ->groupBy('sportsbook');

    $results = \App\Services\GameOdds\GameOdds::select([
        'gameodds.bet_name', 
        \DB::raw('FROM_UNIXTIME(gameodds.timestamp, "%m/%d/%Y %h:%i:%s %p") as formatted_time'), 
        'gameodds.sportsbook',
        'gameodds.selection_points',
        'gameodds.selection_line',
        'gameodds.bet_price'
    ])
    ->joinSub($subQuery, 'sub', function ($join) {
        $join->on('gameodds.sportsbook', '=', 'sub.sportsbook')
        ->whereRaw('gameodds.timestamp = sub.max_timestamp');
    })
    ->where('game_id', $gameId)
    ->where('bet_type', $betType)
    ->where('is_live', $isLive)
    ->where('is_main', $isMain)
    ->where('selection_line', $selectionLine)
    ->orderBy('gameodds.sportsbook')
    ->orderByDesc('gameodds.timestamp')
    ->get();
    \Log::info($selectionLine . ' ' . json_encode($results));
    return $results;
}

function getMatchedBetName($dataObj1, $dataObj2) {

    $dataObj1 = json_decode(json_encode($dataObj1), true);
    $dataObj2 = json_decode(json_encode($dataObj2), true);
    
    // Find all unique matching selection_points
    $matches = [];
    foreach ($dataObj1 as $item1) {
        foreach ($dataObj2 as $item2) {
            if ($item1['selection_points'] === $item2['selection_points']) {
                $matches[$item1['selection_points']]['over'] = $item1;
                $matches[$item1['selection_points']]['under'] = $item2;
            }
        }
    }

    // Find the highest unique selection_points that have both 'over' and 'under'
    $highestMatch = null;
    foreach ($matches as $selectionPoints => $match) {
        if ($highestMatch === null || floatval($selectionPoints) > floatval($highestMatch['selection_points'])) {
            $highestMatch = [
                'selection_points' => $selectionPoints,
                'over' => $match['over'],
                'under' => $match['under'],
            ];
        }
    }

    // Prepare the final output, removing the selection_points from the array keys
    $finalOutput = [];
    if ($highestMatch !== null) {
        $finalOutput['over'] = $highestMatch['over'];
        $finalOutput['under'] = $highestMatch['under'];
    }

    \Log::info('matched: ' . json_encode($finalOutput));
    return $finalOutput;
}