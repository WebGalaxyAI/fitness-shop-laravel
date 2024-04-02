<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            LabelSeeder::class,
            AttributeSeeder::class,
            BrandSeeder::class,
            SliderSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
