<?php

namespace BotDialogs\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Dialogs
 * @package BotDialogs\Laravel\Facades
 */
class Dialogs extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'dialogs';
    }
}