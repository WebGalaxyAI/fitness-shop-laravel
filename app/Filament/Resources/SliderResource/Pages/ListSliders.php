<?php

namespace App\Filament\Resources\SliderResource\Pages;

use Filament\Actions;
use App\Filament\Resources\SliderResource;
use Filament\Resources\Pages\ListRecords;

class ListSliders extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = SliderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
