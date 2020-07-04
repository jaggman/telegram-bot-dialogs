<?php

namespace BotDialogs;

use Illuminate\Support\ServiceProvider;

class DialogsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/dialogs.php', 'dialogs');

        $this->app->alias(Dialogs::class, 'dialogs');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/dialogs.php' => config_path('dialogs.php'),
        ], 'config');
    }

    public function provides()
    {
        return ['dialogs', Dialogs::class];
    }
}
