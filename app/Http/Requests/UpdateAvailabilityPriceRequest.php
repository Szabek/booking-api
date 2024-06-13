<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAvailabilityPriceRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'room_id' => 'required|exists:rooms,id',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'price' => 'required|numeric',
        ];
    }
}
