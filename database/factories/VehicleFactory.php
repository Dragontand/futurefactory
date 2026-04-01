<?php

namespace Database\Factories;

use App\Models\Module;
use App\Models\Modules\Chair;
use App\Models\Modules\Chassis;
use App\Models\Modules\Propulsion;
use App\Models\Modules\SteeringWheel;
use App\Models\Modules\Wheel;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $counter = 0;
        // Make Module seperatly, because the modules do not have a standard id,
        // so they are not returned from ->create() or via ->fresh()
        $chassisModule = Module::factory()->create();
        Chassis::factory()->create(['module_id' => $chassisModule->id]);

        $wheelModule = Module::factory()->create();
        Wheel::factory()->create(['module_id' => $wheelModule->id]);

        $propulsionModule = Module::factory()->create();
        Propulsion::factory()->create(['module_id' => $propulsionModule->id]);

        $steeringWheelModule = Module::factory()->create();
        SteeringWheel::factory()->create(['module_id' => $steeringWheelModule->id]);

        $chairModule = Module::factory()->create();
        Chair::factory()->create(['module_id' => $chairModule->id]);

        // To link compatibility
        $chassis = Chassis::find($chassisModule->id);
        /** @var Wheel $wheel */
        $wheel = Wheel::find($wheelModule->id);
        $wheel->compatibleChassis()->attach($chassisModule->id);

        return [
            'name'                      => 'Vehicle ' . ++$counter,
            'chassis_module_id'         => $chassis->module_id,
            'propulsion_module_id'      => $propulsionModule->id,
            'wheel_module_id'           => $wheel->module_id,
            'steering_wheel_module_id'  => $steeringWheelModule->id,
            'chair_module_id'           => $chairModule->id,
        ];
    }
}
