<?php

namespace App\Services\Telegram;

use App\Services\Telegram\Exceptions\TelegramBotApiException;
use Illuminate\Support\Facades\Http;
use Throwable;

class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    /**
     * @throws TelegramBotApiException
     */
    public static function sendMessage(string $token, int $chatId, string $text): bool
    {
        $text = (str($text))
            ->replace("<", "&lt")
            ->replace(">", "&gt")
            ->replace("&", "&amp")
            ->rtrim(" [] [] \n")
            ->limit(1000)
            ->toString();

        try {
            $response = Http::get(self::HOST . $token . '/sendMessage', [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML',
            ])->throw()->json();

            return $response['ok'] ?? false;
        } catch (Throwable $e) {
            report(new TelegramBotApiException($e->getMessage()));

            return false;
        }

    }
}
