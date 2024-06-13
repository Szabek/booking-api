<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
        request()->merge(['accommodationObjectId' => $this->route('accommodationObject')]);

        return [
            'accommodationObjectId' => 'required|exists:accommodation_objects,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer',
            'basePrice' => 'required|numeric',
            'availabilityStartDate' => 'required|date',
            'availabilityEndDate' => 'required|date|after_or_equal:availabilityStartDate',
        ];
    }
}
