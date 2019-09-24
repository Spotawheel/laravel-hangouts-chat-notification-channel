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
        // Bootstrap code here.

        $this->app->when(Channel::class)
            ->needs(Hangouts::class)
            ->give(function () {
                $hangouts = config('broadcasting.connections.hangouts');

                return new Hangouts(
                    $hangouts['key'],
                    $hangouts['secret'],
                    $hangouts['app_id']
                );
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