<?php

namespace App\Commands;

use Telegram\Bot\Commands\Command;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\StatLink;
use Telegram\Bot\Keyboard\Keyboard;
use App\Models\Setting;


class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Команда Start';

    public function handle()
    {
        $message = $this->getUpdate()->getMessage()->text;
        $setting = Setting::first();
        $ref = null;
        if (preg_match('/^\/start (\d+)$/', $message, $matches)) {
            $user = User::where('tg_id', $matches[1])->first();
            if ($user) {
                $user->coins += $setting->bonus_start;
                $user->save();
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

                $user->coins += $setting->bonus_start;
                $user->save();

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
        $this->replyWithMessage([
            'text' => "<b>🎉 Добро пожаловать! 🎉</b>

Это первый бот в телеграм по игре Brawl Stars, позволяющий тебе получить донат за клики!

Прокачивай бусты, зови друзей, копи монеты Brawl Coin и забирай призы уже сегодня!

<b>👇 Нажимай на кнопку играть и начинай тапать прямо сейчас!</b>",
            'reply_markup' => json_encode($keyboard),
            'parse_mode' => 'HTML'
        ]);
    }
}
