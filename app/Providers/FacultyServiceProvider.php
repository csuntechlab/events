<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FacultyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(
            'App\Contracts\FacultyContract',
            'App\Services\FacultyService'
        );
    }
}
