<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sex_id' => 'required|exists:sexes,id',
            'category' => 'required|string|max:255',
            'subcategory' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'url_selection' => 'required|string|max:255',
        ];
    }
}
