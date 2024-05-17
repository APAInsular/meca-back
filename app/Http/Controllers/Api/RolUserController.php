<?php

// app/Http/Controllers/RolUserController.php
namespace App\Http\Controllers;

use App\Http\Requests\AssignRoleRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\JsonResponse;

class RolUserController extends Controller
{
    public function assignRole(AssignRoleRequest $request): JsonResponse
    {
        $user = User::findOrFail($request->user_id);
        $role = Role::findById($request->rol_id);

        if ($user->hasRole($role->name)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'El usuario ya tiene este rol asignado.',
            ], 400);
        }

        $user->assignRole($role);

        return response()->json([
            'status' => 'success',
            'message' => '¡Rol asignado correctamente!',
            'data' => $user->getRoleNames(),
        ]);
    }

    public function removeRole(AssignRoleRequest $request): JsonResponse
    {
        $user = User::findOrFail($request->user_id);
        $role = Role::findById($request->rol_id);

        if (!$user->hasRole($role->name)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'El usuario no tiene este rol asignado.',
            ], 400);
        }

        $user->removeRole($role);

        return response()->json([
            'status' => 'success',
            'message' => '¡Rol removido correctamente!',
            'data' => $user->getRoleNames(),
        ]);
    }
}
