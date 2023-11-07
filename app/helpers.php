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
        $formula = 1 + ($americanOdds / 100);
    }

    if ($americanOdds < 0) {
         $formula = 1 - (100 / $americanOdds);
    }

    // Return a default value (e.g. for 0 odds)
    return number_format($formula, 2, '.', '');
}

function getOdds($row) {

    $game_id = $row->uid;
    $bet_type = $row->bet_type;
    
    $home_team = $row->home_team;
    $away_team = $row->away_team;

    $best_odds_a = 0.00;
    $best_odds_b = 0.00;

    $selection_line_a = '';
    $selection_line_b = '';

    $sportsbook_a = '';
    $sportsbook_b = '';

    $sports_book = getSportsBook();
    $counter = 0;

    $best_over_odds_query = null;
    $best_under_odds_query = null;
    
    $search_raw_a = "";
    $search_raw_b = "";
    $latest_raw_a = "";
    $latest_raw_b = "";

    $bet_name = null;

    $game = DB::table('gameodds')
    ->select(
        'game_id',
        'bet_type',
        DB::raw("GROUP_CONCAT(DISTINCT(selection) SEPARATOR ',') AS selection"),
        DB::raw("GROUP_CONCAT(DISTINCT(selection_line) SEPARATOR ',') AS selection_line")
    )
    ->where('game_id', $game_id)
    ->where('bet_type', $bet_type)
    ->groupByRaw('game_id, bet_type')
    ->first();

    if (strpos($game->selection, 'Draw') !== false || strpos($game->selection, 'No Goal') !== false ) {
        $data = [
            'best_odds_a'   =>  $best_odds_a,
            'best_odds_b'   =>  $best_odds_b,
            'selection_line_a'   =>  $selection_line_a,
            'selection_line_b'   =>  $selection_line_b,
            'profit_percentage' =>  0,
            'sportsbook_a'  =>  $sportsbook_a,
            'sportsbook_b'  =>  $sportsbook_b
        ];
        return $data;
    } else if (strpos($game->selection_line, 'over') !== false || strpos($game->selection_line, 'under') !== false ) {
        $search_raw_a = "go.selection_line = 'over'";
        $search_raw_b = "go.selection_line = 'under'";
        $latest_raw_a = "x.selection_line = 'over'";
        $latest_raw_b = "x.selection_line = 'under'";
    } else if(strpos($game->selection, $home_team ) !== false || strpos($game->selection,  $away_team) !== false ){
        $search_raw_a = "go.selection LIKE '%".$home_team."%'";
        $search_raw_b = "go.selection LIKE '%".$away_team."%'";
        $latest_raw_a = "x.selection LIKE '%".$home_team."%'";
        $latest_raw_b = "x.selection LIKE '%".$away_team."%'";
    } else if (strpos($game->selection, 'yes') !== false || strpos($game->selection, 'no') !== false ) {
        $search_raw_a = "go.selection LIKE '%yes%'";
        $search_raw_b = "go.selection LIKE '%no%'";
        $latest_raw_a = "x.selection LIKE '%yes%'";
        $latest_raw_b = "x.selection LIKE '%no%'";
    } else if (strpos($game->selection, 'odd') !== false || strpos($game->selection, 'even') !== false ) { 
        $search_raw_a = "go.selection LIKE '%odd%'";
        $search_raw_b = "go.selection LIKE '%even%'";
        $latest_raw_a = "x.selection LIKE '%odd%'";
        $latest_raw_b = "x.selection LIKE '%even%'";
    }

    if ($search_raw_a && $search_raw_b ) {

        $best_over_odds_query = DB::table('gameodds as go')
        ->select(
            'go.bet_type', 
            'go.selection_points', 
            'go.selection_line', 
            'go.bet_name', 
            'go.sportsbook',
            DB::raw('MAX(go.bet_price) as max_bet_price')
        )
        ->whereRaw($search_raw_a)
        ->where('go.game_id', $game_id)
        ->where('go.bet_type', $bet_type)
        ->groupBy('go.sportsbook')
        ->get();

        $notInQuery = $best_over_odds_query->sortByDesc('max_bet_price')->first();
        $notIn = $best_over_odds_query->where('max_bet_price', $notInQuery->max_bet_price)->pluck('sportsbook')->unique()->values()->all();

        $best_under_odds_query = DB::table('gameodds as go')
        ->select(
            'go.bet_type', 
            'go.selection_points', 
            'go.selection_line', 
            'go.bet_name', 
            'go.sportsbook',
            DB::raw('MAX(go.bet_price) as max_bet_price')
        )
        ->whereRaw($search_raw_b)
        ->where('go.game_id', $game_id)
        ->where('go.bet_type', $bet_type)
        ->whereNotIn('go.sportsbook', $notIn )
        ->groupBy('go.sportsbook')
        ->get();

        $bet_name = findMatchedBetName($best_over_odds_query, $best_under_odds_query);
    }


    $highest_over = $best_over_odds_query ? $best_over_odds_query->sortByDesc('max_bet_price')->first() : null;
    $highest_under = $best_under_odds_query ? $best_under_odds_query->sortByDesc('max_bet_price')->first() : null;

    if (!empty($best_over_odds_query) && !empty($best_under_odds_query) && !empty($highest_over) && !empty($highest_under)) {

        $highest_over_bet_price_records = collect($best_over_odds_query)->where('max_bet_price', $highest_over->max_bet_price);
        $highest_under_bet_price_records = collect($best_under_odds_query)->where('max_bet_price', $highest_under->max_bet_price);

        $sportsbooks_over_with_highest_bet_price = $highest_over_bet_price_records->pluck('sportsbook')->unique()->values()->all();
        $sportsbooks_under_with_highest_bet_price = $highest_under_bet_price_records->pluck('sportsbook')->unique()->values()->all();

        $best_odds_a = convertAmericanToDecimalOdds($highest_over->max_bet_price) ?? 0.00;
        $best_odds_b = convertAmericanToDecimalOdds($highest_under->max_bet_price) ?? 0.00;

        $sportsbook_a = sports_book_image($sportsbooks_over_with_highest_bet_price, $sports_book);
        $sportsbook_b = sports_book_image($sportsbooks_under_with_highest_bet_price, $sports_book);
        
        // $selection_line_a = $highest_over->bet_name ?? '';
        // $selection_line_b = $highest_under->bet_name ?? '';

        $selection_line_a = $bet_name['over'] ?? '';
        $selection_line_b = $bet_name['under'] ?? '';
    }

    $profit_percentage = calculateProfit($best_odds_a, $best_odds_b);
    
    $data = [
        'best_odds_a'   =>  $best_odds_a,
        'best_odds_b'   =>  $best_odds_b,
        'selection_line_a'   =>  $selection_line_a,
        'selection_line_b'   =>  $selection_line_b,
        'profit_percentage' =>  $profit_percentage,
        'sportsbook_a'  =>  $sportsbook_a,
        'sportsbook_b'  =>  $sportsbook_b,
        'best_over_odds_query'  =>  $best_over_odds_query,
        'best_under_odds_query'  =>  $best_under_odds_query
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

function findMatchedBetName($queryA, $queryB) {

    $overCollection = collect($queryA->toArray());
    $underCollection = collect($queryB->toArray());

    $highestOverBetName = '';
    $highestUnderBetName = '';

    if ( count($overCollection) > 0 && count($underCollection) > 0 ) {

        // Find the max selection_points for over
        $maxOverSelectionPoints = $overCollection->max('selection_points');

        // Find the max selection_points for under
        $maxUnderSelectionPoints = $underCollection->max('selection_points');

        // Retrieve the bet_name(s) for the highest selection_points for over
        $highestOverBetNames = $overCollection->where('selection_points', $maxOverSelectionPoints)->pluck('bet_name');

        // Retrieve the bet_name(s) for the highest selection_points for under
        $highestUnderBetNames = $underCollection->where('selection_points', $maxUnderSelectionPoints)->pluck('bet_name');

        // If you need the first occurrence or assume only one occurrence you can use first() instead of pluck()
        $highestOverBetName = $overCollection->where('selection_points', $maxOverSelectionPoints)->first();
        $highestUnderBetName = $underCollection->where('selection_points', $maxUnderSelectionPoints)->first();

    }

    // Now you have the bet_name for the highest selection_points on over and under
    return [
        'over' => $highestOverBetName->bet_name ?? '',
        'under' => $highestUnderBetName->bet_name ?? ''
    ];
}