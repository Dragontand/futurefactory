<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
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
            'type'       => 'required|in:assembly,maintenance',
            'robot_id'   => 'required_if:type,maintenance|exists:robots,id',
            'vehicle_id' => 'required_if:type,assembly|exists:vehicles,id',
            'date'        => 'required|date|after_or_equal:today',
            'slot'       => 'required|integer|between:1,4',
        ];
    }
}
