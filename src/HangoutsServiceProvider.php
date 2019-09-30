<?php

namespace NotificationChannels\Hangouts;

use Illuminate\Support\ServiceProvider;

class HangoutsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(Channel::class)
            ->needs(Hangouts::class)
            ->give(function () {
                return new Hangouts();
            });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}