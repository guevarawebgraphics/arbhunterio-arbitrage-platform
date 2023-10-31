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
    \Log::info($americanOdds);
    $formula = 0.00;
    if ($americanOdds > 0) {
        $formula = ($americanOdds / 100) + 1;
    }

    if ($americanOdds < 0) {
        $formula = (100 / abs($americanOdds)) + 1;
    }

    // Return a default value (e.g. for 0 odds)
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

    $best_over_odds = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)
                    ->where('game_id', $row->uid)
                    ->where('selection_line', 'over')
                    ->max('bet_price');

    $best_under_odds = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)
                    ->where('game_id', $row->uid)
                    ->where('selection_line', 'under')
                    ->max('bet_price');

    $sports_book = getSportsBook();

    if ( !empty($best_over_odds) || !empty($best_under_odds) ) {
        
        $best_odds_a = convertAmericanToDecimalOdds($best_over_odds) ?? 0.00;
        $best_odds_b = convertAmericanToDecimalOdds($best_under_odds) ?? 0.00;

        $mergedOdds = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->whereIn('selection_line', ['over','under'] )->get();
        
        $found_matched_over_under = findMatchingBets($mergedOdds->toArray(), null, 1);
        $selection_line_a = isset($found_matched_over_under['over']['bet_name']) ? $found_matched_over_under['over']['bet_name'] : null;
        $selection_line_b = isset($found_matched_over_under['under']['bet_name']) ? $found_matched_over_under['under']['bet_name'] : null;

        $sportsbook_a_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('bet_price', $best_over_odds)->where('selection_line', 'over')->distinct()->pluck('sportsbook');
        $sportsbook_b_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('bet_price', $best_under_odds)->where('selection_line', 'under')->distinct()->pluck('sportsbook');

        $sportsbook_a = sports_book_image($sportsbook_a_query, $sports_book);
        $sportsbook_b = sports_book_image($sportsbook_b_query, $sports_book);

    } else {
        // Binary Wins
        $home_team = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('selection','LIKE','%'.$row->home_team.'%')->max('bet_price');
        $away_team = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('selection','LIKE','%'.$row->away_team.'%')->max('bet_price');
        $is_draw = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('selection','Draw')->count();

        if ($is_draw > 0) {
        
            $best_odds_a = convertAmericanToDecimalOdds($home_team) ?? 0.00;
            $best_odds_b = convertAmericanToDecimalOdds($away_team) ?? 0.00;
            $selection_line_a = 'Draw';

        } else if ( !empty($home_team) || !empty($away_team) ) {
            // Binary
            
            $best_odds_a = convertAmericanToDecimalOdds($home_team) ?? 0.00;
            $best_odds_b = convertAmericanToDecimalOdds($away_team) ?? 0.00;
            
            $bet_name_query = findBetName($row);
            $selection_line_a = $bet_name_query && $bet_name_query != "[]" ? $bet_name_query->TeamA_Bet_Name  :  $row->home_team;
            $selection_line_b = $bet_name_query && $bet_name_query != "[]" ? $bet_name_query->TeamB_Bet_Name  :  $row->away_team;

            $sportsbook_a_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('bet_price', $home_team)->where('selection','LIKE','%'.$row->home_team.'%')->distinct()->pluck('sportsbook');
            $sportsbook_b_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('bet_price', $away_team)->where('selection','LIKE','%'.$row->away_team.'%')->distinct()->pluck('sportsbook');

            $sportsbook_a = sports_book_image($sportsbook_a_query, $sports_book);
            $sportsbook_b = sports_book_image($sportsbook_b_query, $sports_book);

        } else {
        
            $query_yes = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)
                        ->where('selection','yes')->max('bet_price');

            $query_no = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)
                        ->where('selection','no')->max('bet_price');
        
            $query_odd  = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)
                        ->where('selection','odd')->max('bet_price');

            $query_even = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)
                        ->where('selection','even')->max('bet_price');
        


            // If Yes or No
            if ( !empty($query_yes) && !empty($query_no) ) {
                $best_odds_a = convertAmericanToDecimalOdds($query_yes) ?? 0.00;
                $best_odds_b = convertAmericanToDecimalOdds($query_no) ?? 0.00;
                $selection_line_a = 'Yes';
                $selection_line_b = 'No';

                
                $sportsbook_a_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('selection','yes')->where('bet_price', $query_yes)->distinct()->pluck('sportsbook');
                $sportsbook_b_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('selection','no')->where('bet_price', $query_no)->distinct()->pluck('sportsbook');

                $sportsbook_a = sports_book_image($sportsbook_a_query, $sports_book);
                $sportsbook_b = sports_book_image($sportsbook_b_query, $sports_book);
                
            } else if ( !empty($query_odd) && !empty($query_even) ) {
                
                $best_odds_a = convertAmericanToDecimalOdds($query_odd) ?? 0.00;
                $best_odds_b = convertAmericanToDecimalOdds($query_even) ?? 0.00;
                $selection_line_a = 'Odd';
                $selection_line_b = 'Even';
                $sportsbook_a_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('selection','odd')->where('bet_price', $query_odd)->distinct()->pluck('sportsbook');
                $sportsbook_b_query = \App\Services\GameOdds\GameOdds::where('bet_type', $row->bet_type)->where('game_id', $row->uid)->where('selection','even')->where('bet_price', $query_even)->distinct()->pluck('sportsbook');

                $sportsbook_a = sports_book_image($sportsbook_a_query, $sports_book);
                $sportsbook_b = sports_book_image($sportsbook_b_query, $sports_book);
            }

        }
    }

    $profit_percentage = calculateProfit($best_odds_a, $best_odds_b);

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
    
    // Check for division by zero
    if ($odds1 == 0 || $odds2 == 0) {
        return 0;
    }

    // Calculate the profit percentage
    $profitPercentage = (1 - (1 / $odds1 + 1 / $odds2)) * 100;

    // Return the result rounded to two decimal places
    return abs(round($profitPercentage, 2));
}
