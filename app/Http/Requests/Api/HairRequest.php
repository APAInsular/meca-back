<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class HairRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Aquí puedes definir la lógica de autorización si es necesario
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sex_id' => 'required|exists:sexes,id',
            'category' => 'required|string|max:255',
            'subcategory' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'url_selection' => 'required|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'sex_id.required' => 'The sex_id field is required.',
            'sex_id.exists' => 'The selected sex_id is invalid.',
            'category.required' => 'The category field is required.',
            'category.string' => 'The category must be a string.',
            'category.max' => 'The category may not be greater than :max characters.',
            'subcategory.required' => 'The subcategory field is required.',
            'subcategory.string' => 'The subcategory must be a string.',
            'subcategory.max' => 'The subcategory may not be greater than :max characters.',
            'url.required' => 'The URL field is required.',
            'url.string' => 'The URL must be a string.',
            'url.max' => 'The URL may not be greater than :max characters.',
            'url_selection.required' => 'The URL selection field is required.',
            'url_selection.string' => 'The URL selection must be a string.',
            'url_selection.max' => 'The URL selection may not be greater than :max characters.',
        ];
    }
}
