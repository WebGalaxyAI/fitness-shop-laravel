<?php

namespace App\Filament\Resources\LabelResource\Pages;

use App\Filament\Resources\LabelResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLabel extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = LabelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            // ...
        ];
    }
}
