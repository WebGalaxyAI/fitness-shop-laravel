<?php

namespace Database\Seeders;

use App\Helpers\DirManager;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(DirManager $dirManager)
    {
        $data = [
            [
                'name' => [
                    'en' => 'For fitness clubs',
                    'uk' => 'Для фітнес клубів',
                    'ru' => 'Для фитнес клубов',
                ],
                'children' => [
                    [
                        'name' => [
                            'en' => 'Professional cardio equipment',
                            'uk' => 'Професійні кардіотренажери',
                            'ru' => 'Профессиональные кардиотренажеры',
                        ],
                        'image' => 'categories/professional-cardio-equipment.png',
                    ],
                    [
                        'name' => [
                            'en' => 'Weight block simulators',
                            'uk' => 'Вантажоблочні тренажери',
                            'ru' => 'Грузоблочные тренажеры',
                        ],
                        'image' => 'categories/weight-block-simulators.png',
                    ],
                    [
                        'name' => [
                            'en' => 'Free weights',
                            'uk' => 'Тренажери на вільних вагах',
                            'ru' => 'Тренажеры на свободных весах',
                        ],
                        'image' => 'categories/free-weights.png',
                    ],
                    [
                        'name' => [
                            'en' => 'Functional training',
                            'uk' => 'Функціональний тренінг',
                            'ru' => 'Функциональный тренинг',
                        ],
                        'image' => 'categories/functional-training.png',
                    ],
                    [
                        'name' => [
                            'en' => 'Wellness, SPA, Massage',
                            'uk' => 'Wellness, СПА, Масаж',
                            'ru' => 'Wellness, СПА, Массаж',
                        ],
                        'image' => 'categories/wellness-spa-massage.png',
                    ],
                    [
                        'name' => [
                            'en' => 'Sports medicine and rehabilitation',
                            'uk' => 'Спортивна медицина та реабілітація',
                            'ru' => 'Спортивная медицина и реабилитация',
                        ],
                        'image' => 'categories/sports-medicine-rehabilitation.png',
                    ],
                    [
                        'name' => [
                            'en' => 'Free weights',
                            'uk' => 'Вільна вага',
                            'ru' => 'Свободные веса',
                        ],
                        'image' => 'categories/free-weights-2.png',
                    ],
                ],
            ],
            [
                'name' => [
                    'en' => 'Exercise equipment for home',
                    'uk' => 'Тренажери для дому',
                    'ru' => 'Тренажеры для дома',
                ],
                'children' => [
                    [
                        'name' => [
                            'en' => 'Treadmills',
                            'uk' => 'Бігові доріжки',
                            'ru' => 'Беговые дорожки',
                        ],
                        'image' => 'categories/treadmills.png',
                    ],
                    [
                        'name' => [
                            'en' => 'Elliptical trainers',
                            'uk' => 'Еліптичні тренажери',
                            'ru' => 'Эллиптические тренажеры',
                        ],
                        'image' => 'categories/elliptical-trainers.png',
                    ],
                    [
                        'name' => [
                            'en' => 'Exercise bikes',
                            'uk' => 'Велотренажери',
                            'ru' => 'Велотренажеры',
                        ],
                        'image' => 'categories/exercise-bikes.png',
                    ],
                    [
                        'name' => [
                            'en' => 'Ski simulators',
                            'uk' => 'Гірськолижні тренажери',
                            'ru' => 'Горнолыжные тренажеры',
                        ],
                        'image' => 'categories/ski-simulators.png',
                    ],
                    [
                        'name' => [
                            'en' => 'Strength training equipment',
                            'uk' => 'Силові тренажери',
                            'ru' => 'Силовые тренажеры',
                        ],
                        'image' => 'categories/strength-training-equipment.png',
                    ],
                    [
                        'name' => [
                            'en' => 'Rowing machines',
                            'uk' => 'Гребні тренажери',
                            'ru' => 'Гребные тренажеры',
                        ],
                        'image' => 'categories/rowing-machines.png',
                    ],
                    [
                        'name' => [
                            'en' => 'Trampolines',
                            'uk' => 'Батути',
                            'ru' => 'Батуты',
                        ],
                        'image' => 'categories/trampolines.png',
                    ],
                    [
                        'name' => [
                            'en' => 'Gaming tables',
                            'uk' => 'Ігрові столи',
                            'ru' => 'Игровые столы',
                        ],
                        'image' => 'categories/gaming-tables.png',
                    ],
                    [
                        'name' => [
                            'en' => 'Massage chairs',
                            'uk' => 'Масажні крісла',
                            'ru' => 'Массажные кресла',
                        ],
                        'image' => 'categories/massage-chairs.png',
                    ],
                    [
                        'name' => [
                            'en' => 'Fitness accessories',
                            'uk' => 'Фітнес аксесуари',
                            'ru' => 'Фитнес аксессуары',
                        ],
                        'image' => 'categories/fitness-accessories.png',
                    ],
                ],
            ],
            [
                'name' => [
                    'en' => 'Fitness',
                    'uk' => 'Фітнес',
                    'ru' => 'Фитнес',
                ],
                'children' => [
                    [
                        'name' => [
                            'en' => 'Cardio Equipment',
                            'uk' => 'Кардіо обладнання',
                            'ru' => 'Кардио оборудование',
                        ],
                        'children' => [
                            ['name' => ['en' => 'Treadmills', 'uk' => 'Бігові доріжки', 'ru' => 'Беговые дорожки']],
                            ['name' => ['en' => 'Exercise Bikes', 'uk' => 'Велотренажери', 'ru' => 'Велотренажеры']],
                        ],
                    ],
                    [
                        'name' => [
                            'en' => 'Strength Training',
                            'uk' => 'Силовий тренування',
                            'ru' => 'Силовые тренировки',
                        ],
                        'children' => [
                            ['name' => ['en' => 'Dumbbells', 'uk' => 'Гантелі', 'ru' => 'Гантели']],
                            ['name' => ['en' => 'Barbells', 'uk' => 'Штанги', 'ru' => 'Штанги']],
                        ],
                    ],
                ],
            ],
            [
                'name' => [
                    'en' => 'Team Sports',
                    'uk' => 'Командні види спорту',
                    'ru' => 'Командные виды спорта',
                ],
                'children' => [
                    [
                        'name' => [
                            'en' => 'Soccer',
                            'uk' => 'Футбол',
                            'ru' => 'Футбол',
                        ],
                        'children' => [
                            ['name' => ['en' => 'Soccer Balls', 'uk' => 'Футбольні м\'ячі', 'ru' => 'Футбольные мячи']],
                            ['name' => ['en' => 'Goal Posts', 'uk' => 'Ворота', 'ru' => 'Ворота']],
                        ],
                    ],
                    [
                        'name' => [
                            'en' => 'Basketball',
                            'uk' => 'Баскетбол',
                            'ru' => 'Баскетбол',
                        ],
                        'children' => [
                            ['name' => ['en' => 'Basketballs', 'uk' => 'Баскетбольні м\'ячі', 'ru' => 'Баскетбольные мячи']],
                            ['name' => ['en' => 'Hoops', 'uk' => 'Кільця', 'ru' => 'Кольца']],
                        ],
                    ],
                ],
            ],
            [
                'name' => [
                    'en' => 'Outdoor Activities',
                    'uk' => 'Активний відпочинок на природі',
                    'ru' => 'Активный отдых на природе',
                ],
                'children' => [
                    [
                        'name' => [
                            'en' => 'Camping & Hiking',
                            'uk' => 'Кемпінг і похід',
                            'ru' => 'Кемпинг и поход',
                        ],
                        'children' => [
                            ['name' => ['en' => 'Tents', 'uk' => 'Намети', 'ru' => 'Палатки']],
                            ['name' => ['en' => 'Backpacks', 'uk' => 'Рюкзаки', 'ru' => 'Рюкзаки']],
                        ],
                    ],
                    [
                        'name' => [
                            'en' => 'Water Sports',
                            'uk' => 'Водні види спорту',
                            'ru' => 'Водные виды спорта',
                        ],
                        'children' => [
                            ['name' => ['en' => 'Kayaking', 'uk' => 'Каякинг', 'ru' => 'Каякинг']],
                            ['name' => ['en' => 'Surfing', 'uk' => 'Серфінг', 'ru' => 'Серфинг']],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($data as $arr) {
            $category = Category::create($arr);
            if (isset($arr['children'])) {
                $this->createNonRootNodes($arr['children'], $category);
            }
        }

        $dirManager->copyFiles(
            public_path('img/categories'),
            storage_path('app/public/categories')
        );
    }

    public function createNonRootNodes(array $data, Category $parentNode)
    {
        foreach ($data as $arr) {
            $childNode = Category::make($arr)->appendTo($parentNode);
            $childNode->save();
            if (isset($arr['children'])) {
                $this->createNonRootNodes($arr['children'], $childNode);
            }
        }
    }
}
