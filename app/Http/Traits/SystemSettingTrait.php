<?php

namespace App\Http\Traits;

use App\Services\SystemSettings\SystemSetting;
use App\Services\SeoMetas\SeoMeta;

/**
 * Class SystemSettingTrait
 * @package App\Http\Traits
 * @author Guevara Web Graphics Studio
 */
trait SystemSettingTrait
{

    /**
     * @param $code
     *
     * @return mixed
     */
    public function getSystemSettingByCode($code)
    {
        $system_setting = SystemSetting::where('code', $code)->first();
        return $system_setting;
    }

    /**
     * @return mixed
     */
    public function getSystemSettings()
    {
        $system_settings = SystemSetting::get();
        return $system_settings;
    }

    /**
     * Get seo meta fields
     *
     * @param array $page
     *
     * @return mixed
     */
    public function getSeoMeta($page = [])
    {
        $seo_meta = [
            'name' => 'My CMS',
            'author' => 'BJCDL',
            'robots' => 'noindex, nofollow',
            'title' => 'My CMS',
            'keywords' => 'My CMS',
            'description' => 'My CMS V2.0 (Content Management System)',
            'canonical' => '',
        ];

        if(env('APP_ENV') == 'prod' || env('APP_ENV') == 'prod_ssl') {
            $seo_meta['robots'] = 'index, follow';
        }

        $system_settings = $this->getSystemSettings();

        foreach ($system_settings as $system_setting) {
            if ($system_setting->code == 'BJCDL_001') {
                $seo_meta['name'] = $system_setting->value;
                $seo_meta['title'] = $system_setting->value;
            }
            if ($system_setting->code == 'BJCDL_002') {
                $seo_meta['description'] = $system_setting->value;
            }
            if ($system_setting->code == 'BJCDL_003') {
                $seo_meta['email'] = $system_setting->value;
            }
            if ($system_setting->code == 'BJCDL_004') {
                $seo_meta['address'] = $system_setting->value;
            }
            if ($system_setting->code == 'BJCDL_005') {
                $seo_meta['meta_title'] = $system_setting->value;
            }
            if ($system_setting->code == 'BJCDL_006') {
                $seo_meta['meta_keywords'] = $system_setting->value;
            }
            if ($system_setting->code == 'BJCDL_007') {
                $seo_meta['meta_description'] = $system_setting->value;
            }
        }

        if (isset($page) && !empty($page)) {
            if (isset($page->seo_meta_id)) {
                $page_seo_meta = SeoMeta::find($page->seo_meta_id);
                if (!empty($page_seo_meta)) {
                    $seo_meta['title'] = $page_seo_meta->meta_title;
                    $seo_meta['keywords'] = $page_seo_meta->meta_keywords;
                    $seo_meta['description'] = $page_seo_meta->meta_description;
                    $seo_meta['canonical'] = $page_seo_meta->canonical_link;
                }
            }
        }

        view()->share(['seo_meta' => $seo_meta]);
        return $seo_meta;
    }

}
