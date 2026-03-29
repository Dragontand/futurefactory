<?php

namespace App\Models;

use App\Models\Modules\Chair;
use App\Models\Modules\Chassis;
use App\Models\Modules\Propulsion;
use App\Models\Modules\SteeringWheel;
use App\Models\Modules\Wheel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class Module extends Model
{
    /** @use HasFactory<\Database\Factories\ModuleFactory> */
    use HasFactory;

    protected static string $moduleType;

    protected static array $typeMap = [
        'chassis'           => Chassis::class,
        'propulsion'        => Propulsion::class,
        'wheel'             => Wheel::class,
        'steering_wheel'    => SteeringWheel::class,
        'chair'             => Chair::class,
    ];
    // Runs when the model class is first loaded by laravel.
    protected static function booted(): void
    {
        // Makes Eloquent automatically fill in the type when a new model is created.
        static::creating(function (self $model) {
            $model->type = static::$moduleType;
        });
        // Makes Eloquent add an automatic WHERE clause when querying a specific Module subclass.
        // Skipped when called directly on the Module model itself, so Module::all() returns everything.
        static::addGlobalScope(function ($query) {
            if (isset(static::$moduleType)) {
                $query->where('type', static::$moduleType);
            }
        });
    }
    // Overrides Eloquent's default method so that each db row is returned 
    // as the correct subclass, instead of the Module Model.
    public function newFromBuilder($attributes = [], $connection = null): static
    {
        $type  = $attributes['type'] ?? null;
        $class = static::$typeMap[$type] ?? static::class;

        $model = (new $class)->newInstance([], true);
        $model->setRawAttributes((array) $attributes, true);

        return $model;
    }
}
