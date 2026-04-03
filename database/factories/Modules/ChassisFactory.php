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
            'type'          => $type = fake()->randomElement(VehicleType::class),
            'amount_wheels' => $this->matchtype($type),
            'length'        => fake()->numberBetween(500, 17000),
            'width'         => fake()->numberBetween(150, 2500),
            'height'        => fake()->numberBetween(1000, 4000),
        ];
    }

    private function matchType($type)
    {
        $wheelAmount = fake()->randomElement([2, 3, 4, 6, 8]);
        return match($type) {
            VehicleType::Step           => 2,
            VehicleType::Bicycle        => 2,
            VehicleType::Scooter        => 2,
            VehicleType::PassengerCar   => $wheelAmount,
            VehicleType::Truck          => $wheelAmount,
            VehicleType::Bus            => $wheelAmount,
        };
    }
}
