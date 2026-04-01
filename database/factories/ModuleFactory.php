<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Module>
 */
class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'  => fake()->vehicle(),
            'price' => fake()->randomFloat(2, 100, 10000),
            'time'  => fake()->numberBetween(1, 2),
            'image' => 'https://placehold.co/600x400/000000/FFFFFF.png'
        ];
    }
}
