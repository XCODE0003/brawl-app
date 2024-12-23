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
        try {
            $message = $this->getUpdate()->getMessage();
            $fromId = $message->from->id;
            $messageText = $message->text;


            $setting = Setting::first();
            $user = $this->getOrCreateUser($fromId, $messageText, $setting);

            $this->sendWelcomeMessage($user);
        } catch (\Telegram\Bot\Exceptions\TelegramResponseException $e) {
            if ($this->isBotBlockedError($e)) {
                return;
            }
            throw $e;
        }
    }

    private function getOrCreateUser(int $fromId, string $messageText, Setting $setting): User
    {
        $ref = $this->extractReferralCode($messageText);
        $user = User::firstOrNew(['tg_id' => $fromId]);

        if (!$user->exists) {
            $user->fill([
                'tg_id' => $fromId,
                'username' => $this->getUpdate()->getMessage()->from->username,
                'auth_token' => bin2hex(random_bytes(16)),
                'referral_code' => $ref === $fromId ? null : $ref
            ]);
            $user->save();

            $this->handleReferralBonus($ref, $setting, $user);
        } elseif (!$user->auth_token) {
            $user->auth_token = bin2hex(random_bytes(16));
            $user->save();
        }

        return $user;
    }

    private function extractReferralCode(string $message): ?int
    {
        if (preg_match('/^\/start (\d+)$/', $message, $matches)) {
            $referrer = User::where('tg_id', $matches[1])->first();
            if ($referrer) {
                return (int)$matches[1];
            }
        }
        return null;
    }

    private function handleReferralBonus(?int $ref, Setting $setting, User $user): void
    {
        if ($ref) {
            StatLink::where('id', $ref)->increment('count_start');
            $user->increment('coins', $setting->bonus_start);
            User::where('tg_id', $ref)->increment('coins', $setting->bonus_start);
        }
    }

    private function sendWelcomeMessage(User $user): void
    {
        $keyboard = [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Играть',
                        'web_app' => ['url' => env('APP_URL') . '/login/' . $user->auth_token]
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

    private function isBotBlockedError(\Exception $e): bool
    {
        return $e->getCode() === 403 && str_contains($e->getMessage(), 'bot was blocked');
    }
}
