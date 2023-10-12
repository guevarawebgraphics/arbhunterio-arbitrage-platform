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