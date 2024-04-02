<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RutumStoreRequest extends FormRequest
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
            'nombre' => ['required', 'string'],
            'ciudad' => ['required', 'string'],
            'distancia' => ['required', 'numeric'],
            'tiempo' => ['required'],
            'estado' => ['required', 'in:pendiente,comenzada,completada'],
        ];
    }
}
