<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use App\Filament\Resources\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
