<?php

namespace App\Models;

use App\Models\Modules\Chair;
use App\Models\Modules\Chassis;
use App\Models\Modules\Propulsion;
use App\Models\Modules\SteeringWheel;
use App\Models\Modules\Wheel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

// Abstract and is enforced via an observer.
class Module extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function getTypeLabel(): string
    {
        return match(true) {
            $this->chassis !== null         => 'Chassis',
            $this->propulsion !== null      => 'Propulsion',
            $this->wheel !== null           => 'Wheel',
            $this->steeringWheel !== null   => 'Steering Wheel',
            $this->chair !== null           => 'Chair',
            default                         => 'Unknown',
        };
    }

    public function chassis() : HasOne
    {
        return $this->hasOne(Chassis::class, 'module_id');
    }

    public function propulsion() : HasOne
    {
        return $this->hasOne(Propulsion::class, 'module_id');
    }

    public function wheel() : HasOne
    {
        return $this->hasOne(Wheel::class, 'module_id');
    }

    public function steeringWheel() : HasOne
    {
        return $this->hasOne(SteeringWheel::class, 'module_id');
    }

    public function chair() : HasOne
    {
        return $this->hasOne(Chair::class, 'module_id');
    }
}
