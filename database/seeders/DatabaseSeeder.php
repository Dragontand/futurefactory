<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder\Modules;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $users = [
            ['name' => 'John Jacobs', 'email' => 'johnjacobs@example.com', 'password' => 'Test1234', 'role' => UserRole::Admin],
            ['name' => 'Mike Jacobs', 'email' => 'mike@futurefactory.com', 'password' => 'Test1234', 'role' => UserRole::Mechanic],
            ['name' => 'Sarah Jacobs', 'email' => 'sarah@futurefactory.nl', 'password' => 'Test1234', 'role' => UserRole::Schedular],
            ['name' => 'Timmy Jacobs', 'email' => 'timmy@futurefactory.nl', 'password' => 'Test1234', 'role' => UserRole::Buyer],
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }
        $this->call(ModuleSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(RobotSeeder::class);
    }
}
