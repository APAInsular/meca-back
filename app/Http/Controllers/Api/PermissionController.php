<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the permissions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $permissions = Permission::all();

        if ($permissions->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se encontraron permisos!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Permisos encontrados!',
            'data' => $permissions,
        ], 200);
    }

    /**
     * Store a newly created permission in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        $permission = Permission::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => '¡Permiso creado exitosamente!',
            'data' => $permission,
        ], 201);
    }

    /**
     * Display the specified permission.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Permission $permission)
    {
        if (is_null($permission)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el permiso!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando detalles del permiso!',
            'data' => $permission,
        ], 200);
    }

    /**
     * Remove the specified permission from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Permission $permission)
    {
        if (is_null($permission)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el permiso para eliminar!',
            ], 404);
        }

        $permission->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Permiso eliminado!',
        ], 204);
    }

    /**
     * Handle an error with the controller methods.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => '¡Ha ocurrido un error con los métodos del controlador para permisos!',
        ], 400);
    }
}
