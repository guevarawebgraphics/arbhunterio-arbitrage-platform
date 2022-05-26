<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Hash;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    use SystemSettingTrait;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // \Schema::defaultStringLength(255);
        // View::share('seo_meta', $this->getSeoMeta());

        Validator::extend('old_password', function ($attribute, $value, $parameters) {
            return Hash::check($value, auth()->user()->password);
        });
        Validator::replacer('old_password', function ($message, $attribute, $rule, $parameters) {
            return 'The old password you entered is incorrect.';
        });

        if (env('APP_ENV') == 'prod_ssl') {
            url()->forceScheme('https');
        }
    }
}
