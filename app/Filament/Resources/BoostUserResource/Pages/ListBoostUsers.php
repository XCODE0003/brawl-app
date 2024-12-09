<?php

namespace App\Filament\Resources\BoostUserResource\Pages;

use App\Filament\Resources\BoostUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBoostUsers extends ListRecords
{
    protected static string $resource = BoostUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
