<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;

class TotalUser extends Widget
{
    protected static string $view = 'filament.widgets.total-user';

    public function getTotalUsers()
    {
        return User::count();
    }
}
