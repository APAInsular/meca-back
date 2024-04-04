<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'zip_code' => ['required', 'string'],
            'province' => ['required', 'string'],
            'country' => ['required', 'string'],
            'street' => ['required', 'string'],
            'floor_block_building' => ['required', 'string'],
        ];
    }
}
