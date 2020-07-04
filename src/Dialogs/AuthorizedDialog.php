<?php

namespace BotDialogs\Dialogs;

use BotDialogs\Dialog;
use BotDialogs\Exceptions\DialogException;
use Telegram\Bot\Objects\Update;

class AuthorizedDialog extends Dialog
{
    protected $allowedUsers = [];

    public function __construct(Update $update)
    {
        $username = $update->getMessage()->getFrom()->getUsername();

        if (! $username || ! in_array($username, $this->allowedUsers)) {
            throw new DialogException('You have no access to start this dialog');
        }

        parent::__construct($update);
    }
}
