<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoostUsers extends Model
{
    use HasFactory;

    protected $table = 'boost_users';

    protected $fillable = [
        'user_id',
        'boost_id',
        'lvl',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function boost(): BelongsTo
    {
        return $this->belongsTo(Boost::class);
    }
}