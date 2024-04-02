<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    public function run()
    {
        $attributes = [
            [
                'code' => 'color',
                'name' => [
                    'en' => 'Color',
                    'uk' => 'Колір',
                    'ru' => 'Цвет',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => true,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => 'Red',
                        'uk' => 'Червоний',
                        'ru' => 'Красный',
                    ],
                    [
                        'en' => 'Blue',
                        'uk' => 'Синій',
                        'ru' => 'Синий',
                    ],
                    [
                        'en' => 'Green',
                        'uk' => 'Зелений',
                        'ru' => 'Зеленый',
                    ],
                    [
                        'en' => 'Yellow',
                        'uk' => 'Жовтий',
                        'ru' => 'Желтый',
                    ],
                    [
                        'en' => 'Black',
                        'uk' => 'Чорний',
                        'ru' => 'Черный',
                    ],
                    [
                        'en' => 'White',
                        'uk' => 'Білий',
                        'ru' => 'Белый',
                    ],
                ],
            ],
            [
                'code' => 'size',
                'name' => [
                    'en' => 'Size',
                    'uk' => 'Розмір',
                    'ru' => 'Размер',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => true,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => 'Small',
                        'uk' => 'Маленький',
                        'ru' => 'Маленький',
                    ],
                    [
                        'en' => 'Medium',
                        'uk' => 'Середній',
                        'ru' => 'Средний',
                    ],
                    [
                        'en' => 'Large',
                        'uk' => 'Великий',
                        'ru' => 'Большой',
                    ],
                    [
                        'en' => 'XL',
                        'uk' => 'XL',
                        'ru' => 'XL',
                    ],
                ],
            ],
            [
                'code' => 'material',
                'name' => [
                    'en' => 'Material',
                    'uk' => 'Матеріал',
                    'ru' => 'Материал',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => false,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => 'Polyester',
                        'uk' => 'Поліестер',
                        'ru' => 'Полиэстер',
                    ],
                    [
                        'en' => 'Cotton',
                        'uk' => 'Бавовна',
                        'ru' => 'Хлопок',
                    ],
                    [
                        'en' => 'Spandex',
                        'uk' => 'Спандекс',
                        'ru' => 'Спандекс',
                    ],
                    [
                        'en' => 'Leather',
                        'uk' => 'Шкіра',
                        'ru' => 'Кожа',
                    ],
                ],
            ],
            [
                'code' => 'product_type',
                'name' => [
                    'en' => 'Product Type',
                    'uk' => 'Тип продукту',
                    'ru' => 'Тип товара',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => false,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => 'Running Shoes',
                        'uk' => 'Бігове взуття',
                        'ru' => 'Беговая обувь',
                    ],
                    [
                        'en' => 'Basketball Jerseys',
                        'uk' => 'Майки для баскетболу',
                        'ru' => 'Майки для баскетбола',
                    ],
                    [
                        'en' => 'Fitness Equipment',
                        'uk' => 'Фітнес-обладнання',
                        'ru' => 'Фитнес-оборудование',
                    ],
                    [
                        'en' => 'Tennis Rackets',
                        'uk' => 'Тенісні ракетки',
                        'ru' => 'Теннисные ракетки',
                    ],
                ],
            ],
            [
                'code' => 'gender',
                'name' => [
                    'en' => 'Gender',
                    'uk' => 'Стать',
                    'ru' => 'Пол',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => false,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => 'Men',
                        'uk' => 'Чоловіки',
                        'ru' => 'Мужчины',
                    ],
                    [
                        'en' => 'Women',
                        'uk' => 'Жінки',
                        'ru' => 'Женщины',
                    ],
                    [
                        'en' => 'Unisex',
                        'uk' => 'Унісекс',
                        'ru' => 'Унисекс',
                    ],
                ],
            ],
            [
                'code' => 'season',
                'name' => [
                    'en' => 'Season',
                    'uk' => 'Сезон',
                    'ru' => 'Сезон',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => false,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => 'Summer',
                        'uk' => 'Літо',
                        'ru' => 'Лето',
                    ],
                    [
                        'en' => 'Winter',
                        'uk' => 'Зима',
                        'ru' => 'Зима',
                    ],
                    [
                        'en' => 'Spring',
                        'uk' => 'Весна',
                        'ru' => 'Весна',
                    ],
                    [
                        'en' => 'Fall',
                        'uk' => 'Осінь',
                        'ru' => 'Осень',
                    ],
                ],
            ],
            [
                'code' => 'sport_type',
                'name' => [
                    'en' => 'Sport Type',
                    'uk' => 'Вид спорту',
                    'ru' => 'Вид спорта',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => false,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => 'Soccer',
                        'uk' => 'Футбол',
                        'ru' => 'Футбол',
                    ],
                    [
                        'en' => 'Basketball',
                        'uk' => 'Баскетбол',
                        'ru' => 'Баскетбол',
                    ],
                    [
                        'en' => 'Yoga',
                        'uk' => 'Йога',
                        'ru' => 'Йога',
                    ],
                    [
                        'en' => 'Tennis',
                        'uk' => 'Теніс',
                        'ru' => 'Теннис',
                    ],
                ],
            ],
            [
                'code' => 'feature',
                'name' => [
                    'en' => 'Feature',
                    'uk' => 'Особливість',
                    'ru' => 'Особенность',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => false,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => 'Moisture-Wicking',
                        'uk' => 'Відвід вологи',
                        'ru' => 'Удаление влаги',
                    ],
                    [
                        'en' => 'Breathable',
                        'uk' => 'Дихаючий',
                        'ru' => 'Дышащий',
                    ],
                    [
                        'en' => 'UV Protection',
                        'uk' => 'Захист від УФ',
                        'ru' => 'Защита от УФ',
                    ],
                    [
                        'en' => 'Waterproof',
                        'uk' => 'Водонепроникний',
                        'ru' => 'Водонепроницаемый',
                    ],
                ],
            ],
            [
                'code' => 'activity',
                'name' => [
                    'en' => 'Activity',
                    'uk' => 'Вид діяльності',
                    'ru' => 'Вид деятельности',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => false,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => 'Running',
                        'uk' => 'Біг',
                        'ru' => 'Бег',
                    ],
                    [
                        'en' => 'Cycling',
                        'uk' => 'Велосипед',
                        'ru' => 'Велосипед',
                    ],
                    [
                        'en' => 'Swimming',
                        'uk' => 'Плавання',
                        'ru' => 'Плавание',
                    ],
                    [
                        'en' => 'Hiking',
                        'uk' => 'Похід',
                        'ru' => 'Поход',
                    ],
                ],
            ],
            [
                'code' => 'country_of_origin',
                'name' => [
                    'en' => 'Country of Origin',
                    'uk' => 'Країна походження',
                    'ru' => 'Страна происхождения',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => false,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => 'USA',
                        'uk' => 'США',
                        'ru' => 'США',
                    ],
                    [
                        'en' => 'China',
                        'uk' => 'Китай',
                        'ru' => 'Китай',
                    ],
                    [
                        'en' => 'Germany',
                        'uk' => 'Німеччина',
                        'ru' => 'Германия',
                    ],
                    [
                        'en' => 'Italy',
                        'uk' => 'Італія',
                        'ru' => 'Италия',
                    ],
                ],
            ],
            [
                'code' => 'age_group',
                'name' => [
                    'en' => 'Age Group',
                    'uk' => 'Вікова група',
                    'ru' => 'Возрастная группа',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => false,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => 'Adult',
                        'uk' => 'Дорослі',
                        'ru' => 'Взрослые',
                    ],
                    [
                        'en' => 'Youth',
                        'uk' => 'Молодь',
                        'ru' => 'Молодежь',
                    ],
                    [
                        'en' => 'Kids',
                        'uk' => 'Діти',
                        'ru' => 'Дети',
                    ],
                ],
            ],
            [
                'code' => 'weight',
                'name' => [
                    'en' => 'Weight',
                    'uk' => 'Вага',
                    'ru' => 'Вес',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => false,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => 'Lightweight',
                        'uk' => 'Легкий',
                        'ru' => 'Легкий',
                    ],
                    [
                        'en' => 'Medium Weight',
                        'uk' => 'Середня вага',
                        'ru' => 'Средний вес',
                    ],
                    [
                        'en' => 'Heavy Weight',
                        'uk' => 'Важкий',
                        'ru' => 'Тяжелый',
                    ],
                ],
            ],
            [
                'code' => 'technology',
                'name' => [
                    'en' => 'Technology',
                    'uk' => 'Технологія',
                    'ru' => 'Технология',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => false,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => 'Air Cushion',
                        'uk' => 'Повітряний подушка',
                        'ru' => 'Воздушная подушка',
                    ],
                    [
                        'en' => 'Quick Dry',
                        'uk' => 'Швидка сушка',
                        'ru' => 'Быстрое сушение',
                    ],
                    [
                        'en' => 'Gore-Tex',
                        'uk' => 'Гор-Текс',
                        'ru' => 'Гор-Текс',
                    ],
                    [
                        'en' => 'EVA Foam',
                        'uk' => 'EVA Піна',
                        'ru' => 'EVA Пена',
                    ],
                ],
            ],
            [
                'code' => 'closure_type',
                'name' => [
                    'en' => 'Closure Type',
                    'uk' => 'Тип застібки',
                    'ru' => 'Тип застежки',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => false,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => 'Lace-Up',
                        'uk' => 'На шнурках',
                        'ru' => 'На шнурках',
                    ],
                    [
                        'en' => 'Velcro',
                        'uk' => 'На липучці',
                        'ru' => 'На липучке',
                    ],
                    [
                        'en' => 'Zipper',
                        'uk' => 'На блискавці',
                        'ru' => 'На молнии',
                    ],
                ],
            ],
            [
                'code' => 'athlete_endorsement',
                'name' => [
                    'en' => 'Athlete Endorsement',
                    'uk' => 'Підтримка спортсменів',
                    'ru' => 'Поддержка спортсменов',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => false,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => 'LeBron James',
                        'uk' => 'Леброн Джеймс',
                        'ru' => 'Леброн Джеймс',
                    ],
                    [
                        'en' => 'Serena Williams',
                        'uk' => 'Серена Вільямс',
                        'ru' => 'Серена Уильямс',
                    ],
                    [
                        'en' => 'Cristiano Ronaldo',
                        'uk' => 'Кріштіану Роналду',
                        'ru' => 'Криштиану Роналду',
                    ],
                    [
                        'en' => 'Kobe Bryant',
                        'uk' => 'Кобі Брайант',
                        'ru' => 'Коби Брайант',
                    ],
                ],
            ],
            [
                'code' => 'fit_type',
                'name' => [
                    'en' => 'Fit Type',
                    'uk' => 'Паспорт',
                    'ru' => 'Паспорт',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => false,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => 'Regular Fit',
                        'uk' => 'Звичайна посадка',
                        'ru' => 'Обычная посадка',
                    ],
                    [
                        'en' => 'Slim Fit',
                        'uk' => 'Паспорт Slim',
                        'ru' => 'Слим-паспорт',
                    ],
                    [
                        'en' => 'Loose Fit',
                        'uk' => 'Вільна посадка',
                        'ru' => 'Свободная посадка',
                    ],
                ],
            ],
            [
                'code' => 'warranty',
                'name' => [
                    'en' => 'Warranty',
                    'uk' => 'Гарантія',
                    'ru' => 'Гарантия',
                ],
                'frontend_type' => 'checkbox',
                'is_required' => false,
                'is_filterable' => true,
                'values' => [
                    [
                        'en' => '1 Year',
                        'uk' => '1 рік',
                        'ru' => '1 година',
                    ],
                    [
                        'en' => '2 Years',
                        'uk' => '2 роки',
                        'ru' => '2 часа',
                    ],
                    [
                        'en' => 'Lifetime',
                        'uk' => 'Протягом усього життя',
                        'ru' => 'На всю жизнь',
                    ],
                ],
            ],
        ];

        foreach ($attributes as $attributeData) {
            $values = $attributeData['values'];
            unset($attributeData['values']);

            $attribute = Attribute::query()->create($attributeData);

            foreach ($values as $value) {
                $attribute->values()->create([
                    'value' => $value,
                ]);
            }
        }
    }
}

