<?php

namespace BotDialogs;

use Illuminate\Support\Facades\Redis;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

class Dialogs
{
    protected Api $telegram;

    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    public function add(Dialog $dialog): Dialog
    {
        $dialog->setTelegram($this->telegram);

        // save new dialog
        $chatId = $dialog->getChat()->getId();
        $this->setField($chatId, 'next', $dialog->getNext());
        $this->setField($chatId, 'dialog', get_class($dialog));

        return $dialog;
    }

    public function get(Update $update): ?Dialog
    {
        $chatId = $update->getMessage()->getChat()->getId();

        if (! $this->redis()->exists($chatId)) {
            return null;
        }

        $next = $this->redis()->hget($chatId, 'next');
        $name = $this->redis()->hget($chatId, 'dialog');
        $memory = $this->redis()->hget($chatId, 'memory');

        /** @var Dialog $dialog */
        $dialog = new $name($update);
        $dialog->setTelegram($this->telegram);
        $dialog->setNext($next);
        $dialog->setMemory($memory);

        return $dialog;
    }

    public function proceed(Update $update)
    {
        $dialog = $this->get($update);

        if (! $dialog) {
            return;
        }

        $chatId = $dialog->getChat()->getId();
        $dialog->proceed();

        if ($dialog->isEnd()) {
            $this->redis()->del($chatId);
        } else {
            $this->setField($chatId, 'next', $dialog->getNext());
            $this->setField($chatId, 'memory', $dialog->getMemory());
        }
    }

    public function exists(Update $update): bool
    {
        if (! $this->redis()->exists($update->getMessage()->getChat()->getId())) {
            return false;
        }

        return true;
    }

    protected function setField(string $key, string $field, $value)
    {
        $this->redis()->multi();
        $this->redis()->hset($key, $field, $value);
        $this->redis()->expire($key, config('dialogs.expires'));
        $this->redis()->exec();
    }

    /**
     * Get the Redis connection instance.
     *
     * @return \Illuminate\Redis\Connections\Connection
     */
    protected function redis()
    {
        return Redis::connection(config('dialogs.redis.connection'));
    }
}
