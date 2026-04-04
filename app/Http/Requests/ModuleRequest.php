<?php

namespace App\Http\Requests;

use App\Enums\PropulsionType;
use App\Enums\SteeringWheelType;
use App\Enums\UpholsteryType;
use App\Enums\VehicleType;
use App\Enums\WheelType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        $baseRules = [
            'name'  => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:1'],
            'time'  => ['required', 'integer', 'min:1'],
            'image' => ['nullable', 'string'],
        ];

        return match($this->resolveType()) {
            'chassis' => array_merge($baseRules, [
                'vehicle_type'          => ['required', 'string', Rule::in(VehicleType::cases())],
                'amount_wheels'         => ['required', 'integer', 'min:1'],
                'length'                => ['required', 'integer', 'min:1'],
                'width'                 => ['required', 'integer', 'min:1'],
                'height'                => ['required', 'integer', 'min:1'],
            ]),
            'propulsion' => array_merge($baseRules, [
                'propulsion_type'       => ['required', 'string', Rule::in(PropulsionType::cases())],
                'horsepower'            => ['required', 'integer', 'min:1'],
            ]),
            'wheel' => array_merge($baseRules, [
                'wheel_type'            => ['required', 'string', Rule::in(WheelType::cases())],
                'diameter'              => ['required', 'integer', 'min:1'],
                'compatible_chassis'    => ['nullable', 'array'],
                'compatible_chassis.*'  => ['exists:chassis,module_id'],
            ]),
            'steering_wheel' => array_merge($baseRules, [
                'steering_wheel_type'   => ['required', 'string', Rule::in(SteeringWheelType::cases())],
                'special_request'       => 'nullable|string|min:0',
            ]),
            'chair' => array_merge($baseRules, [
                'upholstery_type'       => ['required', 'string', Rule::in(UpholsteryType::cases())],
                'amount'                => ['required', 'integer', 'min:1'],
            ]),
            default => $baseRules
        };
    }

    // Searches for right type
    private function resolveType()
    {
        if (session('module_type')) {
            return session('module_type');
        }

        $module = $this->route('module');
        if (!$module) return null;

        return match(true) {
            $module->chassis !== null       => 'chassis',
            $module->propulsion !== null    => 'propulsion',
            $module->wheel !== null         => 'wheel',
            $module->steeringWheel !== null => 'steering_wheel',
            $module->chair !== null         => 'chair',
            default                         => null,
        };
    }
}
