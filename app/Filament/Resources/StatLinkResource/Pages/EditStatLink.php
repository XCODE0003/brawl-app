<?php

namespace App\Filament\Resources\StatLinkResource\Pages;

use App\Filament\Resources\StatLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStatLink extends EditRecord
{
    protected static string $resource = StatLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
