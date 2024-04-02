<?php

namespace Database\Seeders;

use App\Helpers\DirManager;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Label;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(DirManager $dirManager)
    {
        $products = [
            [
                'brand_id' => 1, // ID бренду
                'sku' => 'RUN001',
                'name' => [
                    'uk' => 'Бігова доріжка Bowflex 1000',
                    'en' => 'Bowflex 1000 Treadmill',
                    'ru' => 'Беговая дорожка Bowflex 1000',
                ],
                'slug' => 'bowflex-1000-treadmill',
                'description' => [
                    'uk' => 'Професійна бігова доріжка Bowflex 1000 для ефективних тренувань вдома.',
                    'en' => 'Professional Bowflex 1000 treadmill for effective home workouts.',
                    'ru' => 'Профессиональная беговая дорожка Bowflex 1000 для эффективных тренировок дома.',
                ],
                'quantity' => 20,
                'price' => 2499.99,
                'sale_price' => 1999.99,
                'active' => true,
            ],
            [
                'brand_id' => 1,
                'sku' => 'RUN002',
                'name' => [
                    'uk' => 'Бігова доріжка Bowflex 3000',
                    'en' => 'Bowflex 3000 Treadmill',
                    'ru' => 'Беговая дорожка Bowflex 3000',
                ],
                'slug' => 'bowflex-3000-treadmill',
                'description' => [
                    'uk' => 'Надійна бігова доріжка Bowflex 3000 з різними програмами тренувань.',
                    'en' => 'Reliable Bowflex 3000 treadmill with various workout programs.',
                    'ru' => 'Надежная беговая дорожка Bowflex 3000 с различными программами тренировок.',
                ],
                'quantity' => 15,
                'price' => 1899.99,
                'sale_price' => 1599.99,
                'active' => true,
            ],

            [
                'brand_id' => 2,
                'sku' => 'RUN003',
                'name' => [
                    'uk' => 'Бігова доріжка Boxing Bar Професіонал 600',
                    'en' => 'Boxing Bar Professional 600 Treadmill',
                    'ru' => 'Беговая дорожка Boxing Bar Профессионал 600',
                ],
                'slug' => 'boxing-bar-profesional-600-treadmill',
                'description' => [
                    'uk' => 'Професійна бігова доріжка Boxing Bar Професіонал 600 для інтенсивних тренувань.',
                    'en' => 'Professional Boxing Bar Professional 600 treadmill for intense workouts.',
                    'ru' => 'Профессиональная беговая дорожка Boxing Bar Профессионал 600 для интенсивных тренировок.',
                ],
                'quantity' => 22,
                'price' => 1999.99,
                'sale_price' => 1699.99,
                'active' => true,
            ],
            [
                'brand_id' => 3,
                'sku' => 'RUN004',
                'name' => [
                    'uk' => 'Бігова доріжка Cardio Power Спринтер 700',
                    'en' => 'Cardio Power Sprinter 700 Treadmill',
                    'ru' => 'Беговая дорожка Cardio Power Спринтер 700',
                ],
                'slug' => 'cardio-power-sprinter-700-treadmill',
                'description' => [
                    'uk' => 'Спеціалізована бігова доріжка Cardio Power Спринтер 700 для швидких тренувань.',
                    'en' => 'Specialized Cardio Power Sprinter 700 treadmill for fast-paced workouts.',
                    'ru' => 'Специализированная беговая дорожка Cardio Power Спринтер 700 для быстрых тренировок.',
                ],
                'quantity' => 15,
                'price' => 1899.99,
                'sale_price' => 1599.99,
                'active' => true,
            ],
            [
                'brand_id' => 4,
                'sku' => 'RUN005',
                'name' => [
                    'uk' => 'Бігова доріжка Cardio Power Pro Мегапрогулянка 800',
                    'en' => 'Cardio Power Pro Megawalker 800 Treadmill',
                    'ru' => 'Беговая дорожка Cardio Power Pro Мегапрогулка 800',
                ],
                'slug' => 'cardio-power-pro-megaprogulyanka-800-treadmill',
                'description' => [
                    'uk' => 'Надійна бігова доріжка Cardio Power Pro Мегапрогулянка 800 для великих відстаней.',
                    'en' => 'Reliable Cardio Power Pro Megawalker 800 treadmill for long distances.',
                    'ru' => 'Надежная беговая дорожка Cardio Power Pro Мегапрогулка 800 для больших расстояний.',
                ],
                'quantity' => 17,
                'price' => 2099.99,
                'sale_price' => 1799.99,
                'active' => true,
            ],
            [
                'brand_id' => 5,
                'sku' => 'RUN006',
                'name' => [
                    'uk' => 'Бігова доріжка Double Fish Скакунець 900',
                    'en' => 'Double Fish Leaper 900 Treadmill',
                    'ru' => 'Беговая дорожка Double Fish Скакунец 900',
                ],
                'slug' => 'double-fish-leaper-900-treadmill',
                'description' => [
                    'uk' => 'Легка бігова доріжка Double Fish Скакунець 900 для підготовки до стрибків.',
                    'en' => 'Lightweight Double Fish Leaper 900 treadmill for jump preparation.',
                    'ru' => 'Легкая беговая дорожка Double Fish Скакунец 900 для подготовки к прыжкам.',
                ],
                'quantity' => 12,
                'price' => 1799.99,
                'sale_price' => 1499.99,
                'active' => true,
            ],
            [
                'brand_id' => 6,
                'sku' => 'RUN007',
                'name' => [
                    'uk' => 'Бігова доріжка Eclipse Повітряна 1000',
                    'en' => 'Eclipse Air 1000 Treadmill',
                    'ru' => 'Беговая дорожка Eclipse Воздушная 1000',
                ],
                'slug' => 'eclipse-air-1000-treadmill',
                'description' => [
                    'uk' => 'Зручна бігова доріжка Eclipse Повітряна 1000 для комфортних тренувань.',
                    'en' => 'Comfortable Eclipse Air 1000 treadmill for comfortable workouts.',
                    'ru' => 'Удобная беговая дорожка Eclipse Воздушная 1000 для комфортных тренировок.',
                ],
                'quantity' => 16,
                'price' => 2299.99,
                'sale_price' => 1899.99,
                'active' => true,
            ],
            [
                'brand_id' => 7,
                'sku' => 'RUN008',
                'name' => [
                    'uk' => 'Бігова доріжка Gym80 Максимум 1100',
                    'en' => 'Gym80 Maximum 1100 Treadmill',
                    'ru' => 'Беговая дорожка Gym80 Максимум 1100',
                ],
                'slug' => 'gym80-maximum-1100-treadmill',
                'description' => [
                    'uk' => 'Професійна бігова доріжка Gym80 Максимум 1100 для високоінтенсивних тренувань.',
                    'en' => 'Professional Gym80 Maximum 1100 treadmill for high-intensity workouts.',
                    'ru' => 'Профессиональная беговая дорожка Gym80 Максимум 1100 для высокоинтенсивных тренировок.',
                ],
                'quantity' => 14,
                'price' => 2599.99,
                'sale_price' => 2199.99,
                'active' => true,
            ],
            [
                'brand_id' => 8,
                'sku' => 'RUN009',
                'name' => [
                    'uk' => 'Бігова доріжка Hyfit Фітнес 1200',
                    'en' => 'Hyfit Fitness 1200 Treadmill',
                    'ru' => 'Беговая дорожка Hyfit Фитнес 1200',
                ],
                'slug' => 'hyfit-fitness-1200-treadmill',
                'description' => [
                    'uk' => 'Бігова доріжка Hyfit Фітнес 1200 з різними програмами тренувань.',
                    'en' => 'Hyfit Fitness 1200 treadmill with various workout programs.',
                    'ru' => 'Беговая дорожка Hyfit Фитнес 1200 с различными программами тренировок.',
                ],
                'quantity' => 20,
                'price' => 1999.99,
                'sale_price' => 1699.99,
                'active' => true,
            ],
            [
                'brand_id' => 9,
                'sku' => 'RUN010',
                'name' => [
                    'uk' => 'Бігова доріжка Kernel Підйом 1300',
                    'en' => 'Kernel Rise 1300 Treadmill',
                    'ru' => 'Беговая дорожка Kernel Подъем 1300',
                ],
                'slug' => 'kernel-rise-1300-treadmill',
                'description' => [
                    'uk' => 'Підвищена бігова доріжка Kernel Підйом 1300 для імітації підйому.',
                    'en' => 'Elevated Kernel Rise 1300 treadmill for simulating uphill workouts.',
                    'ru' => 'Повышенная беговая дорожка Kernel Подъем 1300 для имитации подъема.',
                ],
                'quantity' => 16,
                'price' => 2299.99,
                'sale_price' => 1899.99,
                'active' => true,
            ],
            [
                'brand_id' => 10,
                'sku' => 'RUN011',
                'name' => [
                    'uk' => 'Бігова доріжка Meridien Експерт 1400',
                    'en' => 'Meridien Expert 1400 Treadmill',
                    'ru' => 'Беговая дорожка Meridien Эксперт 1400',
                ],
                'slug' => 'meridien-expert-1400-treadmill',
                'description' => [
                    'uk' => 'Професійна бігова доріжка Meridien Експерт 1400 для тренувань високого рівня.',
                    'en' => 'Professional Meridien Expert 1400 treadmill for high-level workouts.',
                    'ru' => 'Профессиональная беговая дорожка Meridien Эксперт 1400 для тренировок высокого уровня.',
                ],
                'quantity' => 18,
                'price' => 2399.99,
                'sale_price' => 1999.99,
                'active' => true,
            ],
            [
                'brand_id' => 11,
                'sku' => 'RUN012',
                'name' => [
                    'uk' => 'Бігова доріжка Nautilus Адаптер 1500',
                    'en' => 'Nautilus Adapter 1500 Treadmill',
                    'ru' => 'Беговая дорожка Nautilus Адаптер 1500',
                ],
                'slug' => 'nautilus-adapter-1500-treadmill',
                'description' => [
                    'uk' => 'Сучасна бігова доріжка Nautilus Адаптер 1500 з різноманітними налаштуваннями.',
                    'en' => 'Modern Nautilus Adapter 1500 treadmill with versatile settings.',
                    'ru' => 'Современная беговая дорожка Nautilus Адаптер 1500 с разнообразными настройками.',
                ],
                'quantity' => 14,
                'price' => 2099.99,
                'sale_price' => 1799.99,
                'active' => true,
            ],
        ];

        $cat = Category::findBySlug('bigovi-dorizki');
        $attributeValues = AttributeValue::get();
        $labels = Label::query()->get();

        foreach ($products as $productArr) {
            $product = Product::create($productArr);
            $product->categories()->attach($cat);
            $product->labels()->attach($labels->random()->first());
            $product->attributeValues()->attach($attributeValues->random(5));
        }

        $dirManager->copyFiles(
            public_path('img/products'),
            storage_path('app/public/products')
        );
    }
}
