<?php
/**
 * Created by Kirill Zorin <zarincheg@gmail.com>
 * Personal website: http://libdev.ru
 *
 * Date: 18.06.2016
 * Time: 16:45
 */
namespace BotDialogs\Laravel;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use BotDialogs\Dialogs;
use Predis\Client as Redis;

/**
 * Class DialogsServiceProvider
 * @package BotDialogs\Laravel
 */
class DialogsServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/dialogs.php', 'dialogs');

        $this->app->alias(Dialogs::class, 'dialogs');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/dialogs.php' => config_path('dialogs.php'),
        ], 'config');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['dialogs', Dialogs::class];
    }
}