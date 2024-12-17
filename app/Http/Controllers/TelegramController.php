<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Commands\StartCommand;
use Telegram\Bot\Api;

class TelegramController extends Controller
{
    public function handleWebhook()
    {
        try {
            $telegram = app('telegram.bot');
            $telegram->commandsHandler(true);
            
            return response('ok', 200);
            
        } catch (\Exception $e) {
            // Логируем ошибку
            Log::error('Telegram webhook error: ' . $e->getMessage());
            
            // Всё равно возвращаем "ok" для Telegram
            return response('ok', 200);
        }
    }
}