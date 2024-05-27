<?php

namespace App\Enums;

use Illuminate\Support\Arr;

enum SliderType: string
{
    case MainPage = 'main';

    public function name(): string
    {
        return match ($this) {
            self::MainPage => __('Main page'),
        };
    }

    public static function allKeyName(): array
    {
        return Arr::mapWithKeys(self::cases(), fn($v) => [
            $v->value => $v->name(),
        ]);
    }
}
