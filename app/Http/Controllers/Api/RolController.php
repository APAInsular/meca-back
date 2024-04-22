<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::all();

        if ($roles->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se encontraron roles!',
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
            'nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 400);
        }

        $rol = Rol::create([
            'nombre' => $request->input('nombre'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => '¡Rol creado exitosamente!',
            'data' => $rol,
        ], 201);
    }

    public function show(Rol $rol)
    {
        if (!$rol) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Rol no encontrado!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando datos del rol!',
            'data' => $rol,
        ], 200);
    }

    public function update(Request $request, Rol $rol)
    {
        if (!$rol) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Rol no encontrado!',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 400);
        }

        $rol->update([
            'nombre' => $request->input('nombre'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => '¡Rol actualizado!',
            'data' => $rol,
        ], 200);
    }

    public function destroy(Rol $rol)
    {
        if (!$rol) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Rol no encontrado!',
            ], 404);
        }

        $rol->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Rol eliminado!',
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => '¡Ha ocurrido un error con los métodos del controlador para roles!',
        ], 400);
    }
}
