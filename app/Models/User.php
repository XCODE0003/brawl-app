<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Telegram\Bot\Laravel\Facades\Telegram;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tg_id',
        'username',
        'referral_code',
        'last_visit',
        'last_tap',
        'coins',
        'auth_token',
        'energy',
        'energy_max',
    ];
    public function boostUsers()
    {
        return $this->hasMany(BoostUsers::class);
    }

    public function sendMessage($message)
    {
        Telegram::sendMessage([
            'chat_id' => $this->tg_id,
            'text' => $message,
            'parse_mode' => 'MarkdownV2',
        ]);
    }
}