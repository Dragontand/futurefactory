<?php

namespace Database\Factories\Modules;

use App\Enums\SteeringWheelType;
use App\Models\Module;
use App\Models\Modules\SteeringWheel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SteeringWheel>
 */
class SteeringWheelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'module_id'         => Module::factory(),
            'type'              => fake()->randomElement(SteeringWheelType::class),
            'special_request'   => fake()->sentences(asText:true),
        ];
    }
}
