<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RatingStoreRequest extends FormRequest
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
            'rating' => ['required', 'numeric', 'between:1,5'],
            'rateable_type' => ['required', 'string'],
            'rateable_id' => ['required', 'integer'],
        ];
    }
}