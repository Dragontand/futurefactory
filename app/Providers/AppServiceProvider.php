<?php

namespace App\Providers;

use Faker\Generator;
use Faker\Provider\FakeCar;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // To add the FakeCar provider to all faker instances in all factories.
        $this->app->afterResolving(Generator::class, function (Generator $faker) {
            $faker->addProvider(new FakeCar($faker));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
