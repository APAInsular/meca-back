<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class BlogEntryStoreRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
            'description' => ['required', 'string'],
            'main_image' => ['required', 'string'],
        ];
    }
}
