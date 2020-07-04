<?php

namespace BotDialogs\Facades;

use Illuminate\Support\Facades\Facade;

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
