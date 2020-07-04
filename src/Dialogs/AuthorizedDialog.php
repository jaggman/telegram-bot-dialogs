<?php

namespace BotDialogs\Dialogs;

use BotDialogs\Dialog;
use BotDialogs\Exceptions\DialogException;
use Telegram\Bot\Objects\Update;

/**
 * Class AuthorizedDialog
 * @package GreenzoBot\Telegram\Dialogs
 */
class AuthorizedDialog extends Dialog
{
    protected $allowedUsers = [];

    /**
     * @todo Replace basic Exception by the specific
     * @param Update $update
     * @throws DialogException
     */
    public function __construct(Update $update)
    {
        $username = $update->getMessage()->getFrom()->getUsername();

        if (!$username || !in_array($username, $this->allowedUsers)) {
            throw new DialogException('You have no access to start this dialog');
        }

        parent::__construct($update);
    }
}
