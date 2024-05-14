<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RouteUserRequest extends FormRequest
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
            'route_id' => 'required|exists:routes,id', // La ruta debe existir en la tabla routes
            'user_id' => 'required|exists:users,id', // El usuario debe existir en la tabla users
        ];
    }
}
