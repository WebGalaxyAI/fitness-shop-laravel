<?php

namespace Database\Seeders;

use App\Helpers\DirManager;
use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(DirManager $dirManager)
    {
        $brandsData = [
            [
                'name' => 'Bowflex',
                'logo' => 'brands/bowflex.svg',
            ],
            [
                'name' => 'Boxing Bar',
                'logo' => 'brands/boxing-bar.svg',
            ],
            [
                'name' => 'Cardio Power',
                'logo' => 'brands/cardio-power.svg',
            ],
            [
                'name' => 'Cardio Power Pro',
                'logo' => 'brands/cardio-power-pro.svg',
            ],
            [
                'name' => 'Double Fish',
                'logo' => 'brands/double-fish.svg',
            ],
            [
                'name' => 'Eclipse',
                'logo' => 'brands/eclipse.svg',
            ],
            [
                'name' => 'Gym80',
                'logo' => 'brands/gym80.svg',
            ],
            [
                'name' => 'Hyfit',
                'logo' => 'brands/hyfit.svg',
            ],
            [
                'name' => 'Kernel',
                'logo' => 'brands/kernel.svg',
            ],
            [
                'name' => 'Meridien',
                'logo' => 'brands/meridien.svg',
            ],
            [
                'name' => 'Nautilus',
                'logo' => 'brands/nautilus.svg',
            ],
            [
                'name' => 'Octane',
                'logo' => 'brands/octane.svg',
            ],
            [
                'name' => 'Optima',
                'logo' => 'brands/optima.svg',
            ],
            [
                'name' => 'Original',
                'logo' => 'brands/original.svg',
            ],
            [
                'name' => 'Pro Ski Simulator',
                'logo' => 'brands/pro-ski-simulator.svg',
            ],
        ];

        foreach ($brandsData as $brandData) {
            Brand::create([
                'name' => $brandData['name'],
                'logo' => $brandData['logo'],
            ]);
        }

        $dirManager->copyFiles(
            public_path('img/brands'),
            storage_path('app/public/brands')
        );
    }
}
