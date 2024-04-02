<?php

namespace Database\Seeders;

use App\Models\Label;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    public function run()
    {
        $labels = [
            [
                'code' => 'top',
                'name' => [
                    'uk' => 'Топ продажів',
                    'en' => 'Top Sellers',
                    'ru' => 'Лидер продаж',
                ],
                'color' => '#ffa900',
            ],
            [
                'code' => 'new',
                'name' => [
                    'uk' => 'Новинка',
                    'en' => 'New Arrival',
                    'ru' => 'Новинка',
                ],
                'color' => '#2FC509',
            ],
            [
                'code' => 'sale',
                'name' => [
                    'uk' => 'Акція',
                    'en' => 'Sale',
                    'ru' => 'Акция',
                ],
                'color' => '#f84147',
            ],
        ];

        foreach ($labels as $label) {
            Label::query()->create($label);
        }
    }
}

