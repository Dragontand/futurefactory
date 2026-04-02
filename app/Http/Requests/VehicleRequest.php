<?php

namespace App\Http\Requests;

use App\Models\Modules\Wheel;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class VehicleRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name'                      => ['required', 'string', 'max:255'],
            'chassis_module_id'         => ['required', 'exists:chassis,module_id'],
            'propulsion_module_id'      => ['required', 'exists:propulsions,module_id'],
            'wheel_module_id'           => ['required', 'exists:wheels,module_id'],
            'steering_wheel_module_id'  => ['required', 'exists:steering_wheels,module_id'],
            'chair_module_id'           => ['required', 'exists:chairs,module_id'],
        ];
    }

    public function after()
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                // Search for the compatible wheel
                $compatible = DB::table('chassis_wheel')
                    ->where('wheel_module_id', $this->wheel_module_id)
                    ->where('chassis_module_id', $this->chassis_module_id)
                    ->exists();

                if (!$compatible) {
                    $validator->errors()->add('wheel_module_id',
                        'The selectes wheel are not compatible with the chosen chassis.');
                }
            }
        ];
    }
}
