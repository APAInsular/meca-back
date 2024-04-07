<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ObraStoreRequest extends FormRequest
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
            'titulo' => ['required', 'string'],
            'tipo' => ['required', 'in:Escultura,Mural,Pintura'],
            'fecha_creacion' => ['required', 'date'],
            'imagen_principal' => ['required', 'string'],
            'latitud' => ['required', 'numeric'],
            'longitud' => ['required', 'numeric'],
            'significado' => ['required', 'string'],
        ];
    }
}
