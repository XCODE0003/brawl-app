<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'count_start',
        'link',
    ];
}
