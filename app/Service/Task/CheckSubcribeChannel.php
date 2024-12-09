<?php

namespace App\Service\Task;

use Telegram\Bot\Laravel\Facades\Telegram;

class CheckSubcribeChannel
{
    public function execute(string $chat_id, string $channel_id): bool
    {
        try {
            $member = Telegram::getChatMember([
                'chat_id' => $channel_id,
                'user_id' => $chat_id
            ]);

            $status = $member['status'];

            return in_array($status, ['creator', 'administrator', 'member']);
        } catch (\Exception $e) {
            return false;
        }
    }
}