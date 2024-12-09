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
        $telegram = app('telegram.bot');

        $update = $telegram->commandsHandler(true);

        return response('ok');
    }
}