<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class EntradaBlogStoreRequest extends FormRequest
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
            'título' => ['required', 'string'],
            'contenido' => ['required', 'string'],
            'descripción' => ['required', 'string'],
            'imagen_principal' => ['required', 'string'],
            'título' => ['required', 'string'],
            'contenido' => ['required', 'string'],
            'descripción' => ['required', 'string'],
            'imagen_principal' => ['required', 'string'],
            'título' => ['required', 'string'],
            'contenido' => ['required', 'string'],
            'descripción' => ['required', 'string'],
            'imagen_principal' => ['required', 'string'],
            'imagen_principal' => ['required', 'string'],
            'título' => ['required', 'string'],
            'contenido' => ['required', 'string'],
            'descripción' => ['required', 'string'],
            'imagen_principal' => ['required', 'string'],
            'título' => ['required', 'string'],
            'contenido' => ['required', 'string'],
            'descripción' => ['required', 'string'],
            'imagen_principal' => ['required', 'string'],
            'título' => ['required', 'string'],
            'contenido' => ['required', 'string'],
            'descripción' => ['required', 'string'],
            'imagen_principal' => ['required', 'string'],
        ];
    }
}
