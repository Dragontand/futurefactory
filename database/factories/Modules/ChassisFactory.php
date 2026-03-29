<?php

namespace Database\Factories\Modules;

use App\Enums\VehicleType;
use App\Models\Module;
use App\Models\Modules\Chassis;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Chassis>
 */
class ChassisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'module_id'     => Module::factory(),
            'type'          => fake()->randomElement(VehicleType::class),
            'amount_wheels' => fake()->randomElement([2, 3, 4, 6, 8]),
            'length'        => fake()->numberBetween(500, 17000),
            'width'         => fake()->numberBetween(150, 2500),
            'height'        => fake()->numberBetween(1000, 4000),
        ];
    }
}
