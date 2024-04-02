<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class EventoStoreRequest extends FormRequest
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
            'max_inscritos' => ['required', 'integer'],
            'tipo_usuario' => ['required', 'in:creador,participante'],
        ];
    }
}
