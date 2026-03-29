<?php

namespace Database\Seeders;

use App\Models\Modules\Chair;
use App\Models\Modules\Chassis;
use App\Models\Modules\Propulsion;
use App\Models\Modules\SteeringWheel;
use App\Models\Modules\Wheel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chassis::factory(5)->create();
        Propulsion::factory(5)->create();
        Wheel::factory(5)->create();
        SteeringWheel::factory(5)->create();
        Chair::factory(5)->create();

        $chassis = Chassis::all();
        $wheels  = Wheel::all();

        $wheels->each(fn(Wheel $wheel)
            => $wheel->compatibleChassis()->attach(
                $chassis->random(rand(1,3))
            )
        );
    }
}
