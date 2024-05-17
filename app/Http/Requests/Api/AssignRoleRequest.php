<?php

// app/Http/Requests/AssignRoleRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cambia esto según tus necesidades de autorización
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'rol_id' => 'required|exists:roles,id',
        ];
    }
}

