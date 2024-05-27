<?php

namespace App\Filament\Resources\LabelResource\Pages;

use App\Filament\Resources\LabelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLabel extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = LabelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }

}
