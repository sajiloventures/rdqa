<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class HelperClassServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // For AclHelper class
        App::bind('aclhelper', function()
        {
            return new \App\Classes\AclHelper();
        });
        App::bind('apphelper', function()
        {
            return new \App\Classes\AppHelper();
        });
        App::bind('modelhelper', function()
        {
            return new \App\Classes\ModelHelper();
        });
        App::bind('viewhelper', function()
        {
            return new \App\Classes\ViewHelper();
        });
        App::bind('adminMenuHelper', function()
        {
            return new \App\Classes\AdminMenuHelper();
        });
        App::bind('appExceptionHandler', function()
        {
            return new \App\Classes\AppExceptionHandler;
        });
    }
}
