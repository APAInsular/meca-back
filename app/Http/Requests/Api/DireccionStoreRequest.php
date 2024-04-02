<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class DireccionStoreRequest extends FormRequest
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
            'direccion' => ['required', 'string'],
            'ciudad' => ['required', 'string'],
            'cp' => ['required', 'string'],
            'provincia' => ['required', 'string'],
            'pais' => ['required', 'string'],
            'calle' => ['required', 'string'],
            'piso_bloque_edificio' => ['required', 'string'],
        ];
    }
}
