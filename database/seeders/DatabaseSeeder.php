<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Fuel;
use App\Models\Report;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $fuel = [
            [
                'name' => 'Бензин',
                'rest' => 500,
                'price' => 7,
            ],
            [
                'name' => 'Солярка',
                'rest' => 400,
                'price' => 5.3,
            ],
            [
                'name' => 'Дизель',
                'rest' => 450,
                'price' => 4,
            ]
        ];

        foreach ($fuel as $item) {
            Fuel::factory()->create($item);
        }

        $car = [
            [
                'name' =>'nissan',
                'wallet' => 527,
                'fuel_id' => 1,
                'fuel_tank' => 100,
                'fuel_rest' => 30,
            ],
            [
                'name' =>'renault',
                'wallet' => 200,
                'fuel_id' => 2,
                'fuel_tank' => 80,
                'fuel_rest' => 20,
            ],
            [
                'name' =>'honda',
                'wallet' => 158,
                'fuel_id' => 3,
                'fuel_tank' => 110,
                'fuel_rest' => 50,
            ],
            [
                'name' =>'bmw',
                'wallet' => 700,
                'fuel_id' => 1,
                'fuel_tank' => 150,
                'fuel_rest' => 60,
            ],
            [
                'name' =>'kamaz',
                'wallet' => 150,
                'fuel_id' => 2,
                'fuel_tank' => 100,
                'fuel_rest' => 20,
            ],
        ];

        foreach ($car as $item) {
            Car::factory()->create($item);
        }


        Report::factory()->create([
            'car_id' => 1,
            'refuel' => 70,
            'price' => 490,
        ]);

    }
}
