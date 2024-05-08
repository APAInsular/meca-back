<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{

    public function assignPermissionsToRoles()
    {
        $publicRole = Role::where('name', 'Public User')->first();
        $privateRole = Role::where('name', 'Private User')->first();
        $moderatorRole = Role::where('name', 'Moderator')->first();
        $eventAdminRole = Role::where('name', 'Event Admin')->first();
        $adminRole = Role::where('name', 'Admin')->first();

        $publicPermissions = Permission::whereIn('name', [
            'access_public_works_info',
            'access_public_routes',
            'read_public_blog',
        ])->get();

        $privatePermissions = Permission::whereIn('name', [
            'access_complete_works_info',
            'view_private_routes_events',
            'read_comment_public_blog',
        ])->get();

        $moderatorPermissions = Permission::whereIn('name', [
            'edit_delete_blog_comments',
            'moderate_routes_events',
            'verify_completed_achievements',
        ])->get();

        $eventAdminPermissions = Permission::whereIn('name', [
            'create_edit_delete_events',
            'assign_roles_for_events',
            'manage_participation_in_events',
        ])->get();

        $adminPermissions = Permission::all();

        $publicRole->syncPermissions($publicPermissions);
        $privateRole->syncPermissions($privatePermissions);
        $moderatorRole->syncPermissions($moderatorPermissions);
        $eventAdminRole->syncPermissions($eventAdminPermissions);
        $adminRole->syncPermissions($adminPermissions);

        return response()->json([
            'status' => 'success',
            'message' => 'Permisos asignados a roles correctamente.',
        ], 200);
    }

    public function index()
    {
        $roles = Role::all();

        if ($roles->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se encontraron Roles!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Roles encontrados!',
            'data' => $roles,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 400);
        }

        $role = Role::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => '¡Role creado exitosamente!',
            'data' => $role,
        ], 201);
    }

    public function show(Role $Role)
    {
        if (!$Role) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Role no encontrado!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando datos del Role!',
            'data' => $Role,
        ], 200);
    }

    public function update(Request $request, Role $Role)
    {
        if (!$Role) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Role no encontrado!',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 400);
        }

        $Role->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => '¡Role actualizado!',
            'data' => $Role,
        ], 200);
    }

    public function destroy(Role $Role)
    {
        if (!$Role) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Role no encontrado!',
            ], 404);
        }

        $Role->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Role eliminado!',
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => '¡Ha ocurrido un error con los métodos del controller para Roles!',
        ], 400);
    }
}
