<?php

namespace Database\Seeders;

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

        User::factory()->create([
            'name' => 'John Jacobs',
            'email' => 'johnjacobs@example.com',
            'password' => 'Test1234',
            'role' => 'admin'
        ]);
        $this->call(ModuleSeeder::class);
        $this->call(VehicleSeeder::class);
    }
}
