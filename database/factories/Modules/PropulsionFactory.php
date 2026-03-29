<?php

namespace Database\Factories\Modules;

use App\Enums\PropulsionType;
use App\Models\Module;
use App\Models\Modules\Propulsion;
use Faker\Provider\FakeCar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Propulsion>
 */
class PropulsionFactory extends Factory
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
            'type'          => fake()->randomElement(PropulsionType::class),
            'horsepower'    => fake()->vehicleEnginePowerValue(),
        ];
    }
}
