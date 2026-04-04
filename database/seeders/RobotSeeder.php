<?php

namespace Database\Seeders;

use App\Enums\RobotAccountability;
use App\Models\Robot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RobotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'TwoWheels', 'accountability' => RobotAccountability::TwoWheeledVehicles],
            ['name' => 'HydroBoy', 'accountability' => RobotAccountability::HydrogenVehicles],
            ['name' => 'HeavyD', 'accountability' => RobotAccountability::HeavyVehicles],
            ['name' => 'ElectroBoy', 'accountability' => RobotAccountability::ElectricVehicles],
        ];
        foreach ($data as $item)
        {
            Robot::create([
            'name' => $item['name'],
            'accountability' => $item['accountability'],
        ]);
        }
    }
}
