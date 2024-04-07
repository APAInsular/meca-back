<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SubLogroStoreRequest extends FormRequest
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
            'descripcion' => ['required', 'string'],
            'estado' => ['required', 'in:pendiente,en_curso,completado'],
            'tiempo' => ['required'],
        ];
    }
}
