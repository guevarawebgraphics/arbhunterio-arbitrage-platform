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

function marketTypes () {
    $main_markets = [
        '1st Half Moneyline',
        '1st Half Moneyline 3-Way',
        '2nd Half Moneyline',
        'Moneyline',
        'Moneyline 3-Way',
        'Game Spread',
        'Point Spread',
        'Total Goals',
        'Total Points',
        'Total Sets',
        'Both Teams To Score',
        'Draw No Bet',
        'First Team To Score',
        'Last Team To Score',
        'Total Corners',
        'Total Games'
    ];

    $alternate_markets = [
        '1st Half Asian Handicap',
        '1st Half Point Spread',
        '1st Half Total Corners',
        '1st Half Total Goals',
        '1st Half Total Goals Odd/Even',
        '1st Half Total Points',
        '1st Half Total Points Odd/Even',
        '2nd Half Asian Handicap',
        '2nd Half Point Spread',
        '2nd Half Total Corners',
        '2nd Half Total Goals Odd/Even',
        '2nd Half Total Points',
        'Total Corners Odd/Even',
        'Total Goals Odd/Even',
        'Total Points Odd/Even',
        'Total Sets Exact',
        'Total Tiebreaks',
        '1st Map Handicap',
        '2nd Map Handicap',
        '3rd Map Handicap',
        '1st Map Moneyline',
        '2nd Map Moneyline',
        '3rd Map Moneyline',
        '1st Map Total Kills',
        '2nd Map Total Kills',
        '3rd Map Total Kills',
        'Asian Handicap',
        'Set Handicap',
        'Map Handicap',
        '1st Set Total Games',
        '1st Set Game Spread',
        '2nd Set Moneyline',
        '1st Half Race To 10 Points',
        '1st Half Race To 15 Points',
        '1st Half Race To 20 Points',
        '1st Half Race To 25 Points',
        '2nd Half Race To 10 Points',
        '2nd Half Race To 15 Points',
        '2nd Half Race To 20 Points',
        '2nd Half Race To 25 Points',
        'Team Total Corners',
        'Team Total'
    ];


    $player_props = [
        'Anytime Goal Scorer',
        'First Goal Scorer',
        'Last Goal Scorer',
        'Player Assists',
        'Player Goals',
        'Player Shots Attempted',
        'Player Shots On Target',
        'Set Betting',
        'To Win 1st Set',
        'Will There Be Overtime'
    ];


    return $data = [
        'main_markets'  =>  $main_markets,
        'alternate_markets' =>  $alternate_markets,
        'player_props'  =>  $player_props
    ] ;


}