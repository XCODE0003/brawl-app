<?php

namespace App\Commands;

use Telegram\Bot\Commands\Command;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\StatLink;
use Telegram\Bot\Keyboard\Keyboard;


class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Команда Start';

    public function handle()
    {
        $message = $this->getUpdate()->getMessage()->text;
        Log::info($message);
        $ref = null;
        if (preg_match('/^\/start (\d+)$/', $message, $matches)) {
            $user = User::where('tg_id', $matches[1])->first();
            if ($user) {
                $ref = $matches[1];
            } else {
                $stat = StatLink::where('id', $matches[1])->first();
                if ($stat) {
                    $stat->count_start++;
                    $stat->save();
                }
            }
        }
        $auth_token = bin2hex(random_bytes(16));
        $user = User::where('tg_id', $this->getUpdate()->getMessage()->from->id)->first();
        if (!$user) {
            $user = User::create([
                'tg_id' => $this->getUpdate()->getMessage()->from->id,
                'username' => $this->getUpdate()->getMessage()->from->username,
                'auth_token' => $auth_token,
            ]);
            if ($ref) {
                $user->referral_code = $ref === $user->tg_id ? null : $ref;
                $user->save();
            }
        }
        $user->auth_token = $auth_token;
        $user->save();
        $keyboard = [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Начни играть',
                        'web_app' => [
                            'url' => env('APP_URL') . '/login/' . $user->auth_token
                        ]
                    ]
                ]
            ]
        ];
        $this->replyWithMessage(['text' => 'Привет! Я бот.', 'reply_markup' => json_encode($keyboard)]);
    }
}
