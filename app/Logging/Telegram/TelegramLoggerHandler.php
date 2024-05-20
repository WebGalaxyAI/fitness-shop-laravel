<?php

namespace App\Logging\Telegram;

use App\Services\Telegram\Exceptions\TelegramBotApiException;
use App\Services\Telegram\TelegramBotApi;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\LogRecord;

class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected int $chatId;
    protected string $token;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);
        parent::__construct($level);

        $this->chatId = (int) $config['chat_id'];
        $this->token = $config['token'];
    }

    /**
     * @throws TelegramBotApiException
     */
    protected function write(LogRecord $record): void
    {
        TelegramBotApi::sendMessage(
            $this->token,
            $this->chatId,
            $record->formatted
        );
    }
}
