<?php

namespace Database\Factories\Modules;

use App\Enums\UpholsteryType;
use App\Models\Module;
use App\Models\Modules\Chair;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Chair>
 */
class ChairFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'module_id' => Module::factory(),
            'type'      => fake()->randomElement(UpholsteryType::class),
            'amount'    => fake()->numberBetween(0, 50),
        ];
    }
}
