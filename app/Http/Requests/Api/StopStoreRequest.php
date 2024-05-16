<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StopStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Puedes ajustar la lógica de autorización según tus necesidades
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'route_id' => 'required|exists:routes,id',
            'stoppable_type' => 'required|in:App\Models\Monument,App\Models\Sponsor',
            'stoppable_id' => 'required|exists:stops,id',
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
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede exceder los 255 caracteres.',
            'route_id.required' => 'El ID de la ruta es obligatorio.',
            'route_id.exists' => 'La ruta especificada no existe.',
            'stoppable_type.required' => 'El tipo de stoppable es obligatorio.',
            'stoppable_type.in' => 'El tipo de stoppable solo puede ser "Monument" o "Sponsor".',
            'stoppable_id.required' => 'El ID de stoppable es obligatorio.',
            'stoppable_id.exists' => 'El stoppable especificado no existe.',
        ];
    }
}
