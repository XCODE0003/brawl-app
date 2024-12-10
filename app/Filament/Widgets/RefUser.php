<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;

class RefUser extends Widget
{
    protected static string $view = 'filament.widgets.ref-user';

    public function getRefUsers()
    {
        return User::where('referral_code', auth()->user()->id)->get()->count();
    }
}
