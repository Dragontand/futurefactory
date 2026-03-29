<?php

namespace Database\Factories\Modules;

use App\Enums\WheelType;
use App\Models\Module;
use App\Models\Modules\Wheel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Wheel>
 */
class WheelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'module_id'             => Module::factory(),
            'type'                  => fake()->randomElement(WheelType::class),
            'diameter'              => fake()->numberBetween(125, 1000),
        ];
    }
}
