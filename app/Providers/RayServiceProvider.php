<?php

namespace App\Providers;

use Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class RayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('sort10', function ($attribute, $value, $parameters, $validator) {
            $uniqueVal     = array_unique($value);
            sort($uniqueVal);
            $correctCount  = count($uniqueVal) == 10;
            $correctValues = (end($uniqueVal) - $uniqueVal[0]) == 9;

            return $correctCount && $correctValues;
        });

        Validator::extend('color', function ($attribute, $value, $parameters, $validator) {
            return (bool) preg_match('/#([a-f0-9]{3}){1,2}\b/i', $value);
        });

        Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, current($parameters));
        });

        // View::composer('stats', function($view) {
        //     $view->with('stats', app('App\Stats'));
        // });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
