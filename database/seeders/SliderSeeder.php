<?php

namespace Database\Seeders;

use App\Helpers\DirManager;
use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(DirManager $dirManager)
    {
        $data = [
            [
                'title' => [
                    'en' => 'Zero Runner',
                    'uk' => 'Нульовий Бігун',
                    'ru' => 'Ноль Раннер',
                ],
                'text' => [
                    'en' => 'Zero-impact running for joints',
                    'uk' => 'Біг з нульовим ударним навантаженням на суглоби',
                    'ru' => 'Бег без ударных нагрузок на суставы',
                ],
                'button' => [
                    'en' => 'Learn More',
                    'uk' => 'Дізнатись більше',
                    'ru' => 'Узнать больше',
                ],
                'image' => 'sliders/girl-run.png',
            ],
            [
                'title' => [
                    'en' => 'Treadmill',
                    'uk' => 'Бігова доріжка',
                    'ru' => 'Беговая дорожка',
                ],
                'text' => [
                    'en' => 'For marathon training',
                    'uk' => 'Для підготовки до марафону',
                    'ru' => 'Для подготовки к марафону',
                ],
                'button' => [
                    'en' => 'Learn More',
                    'uk' => 'Дізнатись більше',
                    'ru' => 'Узнать больше',
                ],
                'image' => 'sliders/man-run.png',
            ],
            [
                'title' => [
                    'en' => 'Strength Training',
                    'uk' => 'Силові тренування',
                    'ru' => 'Силовые тренировки',
                ],
                'text' => [
                    'en' => 'Build muscle and increase strength',
                    'uk' => 'Набирайте м’язи та збільшуйте силу',
                    'ru' => 'Набирайте мышцы и увеличивайте силу',
                ],
                'button' => [
                    'en' => 'Explore',
                    'uk' => 'Дослідити',
                    'ru' => 'Исследовать',
                ],
                'image' => 'sliders/arny-gym.png',
            ],
            [
                'title' => [
                    'en' => 'Yoga & Meditation',
                    'uk' => 'Йога та медитація',
                    'ru' => 'Йога и медитация',
                ],
                'text' => [
                    'en' => 'Balance your mind, body, and spirit',
                    'uk' => 'Збалансуйте свій розум, тіло та дух',
                    'ru' => 'Сбалансируйте свой разум, тело и дух',
                ],
                'button' => [
                    'en' => 'Discover',
                    'uk' => 'Відкрити',
                    'ru' => 'Открыть',
                ],
                'image' => 'sliders/yoga.png',
            ],
        ];

        foreach ($data as $arr) {
            Slider::create($arr);
        }

        $dirManager->copyFiles(
            public_path('img/front/slider'),
            storage_path('app/public/sliders')
        );
    }
}
