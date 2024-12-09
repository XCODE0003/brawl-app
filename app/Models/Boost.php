<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boost extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'lvl_prices',
    ];

    protected $casts = [
        'lvl_prices' => 'array',
    ];

    public function getBoostMaxLvl(): int
    {
        return count($this->lvl_prices);
    }
}
