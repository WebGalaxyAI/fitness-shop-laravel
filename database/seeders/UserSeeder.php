<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $employees = [
            [
                'name' => 'Олександр Усик',
                'email' => 'usik@gmail.com',
                'country_iso' => 'UA',
                'city' => 'Kyiv',
                'street' => 'Головна',
                'house_number' => '1',
                'zip_code' => '01001',
                'role' => 'super admin',
            ],
            [
                'name' => 'Володимир Кличко',
                'email' => 'klichko@gmail.com',
                'country_iso' => 'UA',
                'city' => 'Kyiv',
                'street' => 'Богдана Хмельницького',
                'house_number' => '10',
                'zip_code' => '02020',
                'role' => 'manager',
            ],
            [
                'name' => 'Віталій Кличко',
                'email' => 'v.klichko@gmail.com',
                'country_iso' => 'UA',
                'city' => 'Kyiv',
                'street' => 'Тараса Шевченка',
                'house_number' => '25',
                'zip_code' => '03030',
                'role' => 'admin',
            ],
            [
                'name' => 'Василь Ломаченко',
                'email' => 'lomachenko@gmail.com',
                'country_iso' => 'UA',
                'city' => 'Bilhorod-Dnistrovskyi',
                'street' => 'Спортивна',
                'house_number' => '5',
                'zip_code' => '35050',
                'role' => 'manager',
            ],
            [
                'name' => 'Андрій Шевченко',
                'email' => 'shevchenko@gmail.com',
                'country_iso' => 'UA',
                'city' => 'Kyiv',
                'street' => 'Шевченка',
                'house_number' => '15',
                'zip_code' => '04040',
                'role' => 'writer',
            ],
            [
                'name' => 'Володимир Боклан',
                'email' => 'volodymyr.boklan@gmail.com',
                'country_iso' => 'UA',
                'city' => 'Kyiv',
                'street' => 'Липська',
                'house_number' => '7',
                'zip_code' => '06060',
                'role' => 'writer',
            ],
            [
                'name' => 'Тарас Цимбалюк',
                'email' => 'cymbalyuk@gmail.com',
                'country_iso' => 'UA',
                'city' => 'Lviv',
                'street' => 'Івана Франка',
                'house_number' => '12',
                'zip_code' => '79079',
                'role' => 'writer',
            ],
            [
                'name' => 'Євген Коноплянка',
                'email' => 'konoplyanka@gmail.com',
                'country_iso' => 'UA',
                'city' => 'Kirovohrad',
                'street' => 'Соборності',
                'house_number' => '9',
                'zip_code' => '25025',
                'role' => 'writer',
            ],
        ];

        foreach ($employees as $person) {
            $user = User::factory([
                'name' => $person['name'],
                'email' => $person['email'],
            ])
                ->has(UserAddress::factory([
                    'country_iso' => $person['country_iso'],
                    'city' => $person['city'],
                    'street' => $person['street'],
                    'house_number' => $person['house_number'],
                    'zip_code' => $person['zip_code'],
                ]), 'addresses')
                ->create();
            $user->assignRole($person['role']);
        }

        User::factory(100)->create()->each(function ($user) {
            UserAddress::factory(rand(1, 2))->create(['user_id' => $user->id]);
        });
    }
}
