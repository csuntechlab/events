<?php
/**
 * Created by PhpStorm.
 * User: Carlos Benavides
 * Date: 7/13/2018
 * Time: 5:22 PM
 */

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class ClassServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Contracts\ClassContract',
            'App\Services\ClassService'
        );
    }

}