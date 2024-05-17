<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\RouteUserRequest;
use App\Models\RouteUser;

class RouteUserController extends Controller
{
    public function index()
    {
        $routes_user = RouteUser::all();

        if ($routes_user->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se encontraron rutas para users!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡rutas con user encontrados!',
            'data' => $routes_user,
        ], 200);
    }

    public function store(RouteUserRequest $request)
    {

        $routes_user = RouteUser::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => '¡ruta con user creada exitosamente!',
            'data' => $routes_user,
        ], 201);
    }

    public function show(string $id)
    {
        $routes_user = RouteUser::find($id);

        if (is_null($routes_user)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la ruta con los users!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando detalles del ruta!',
            'data' => $routes_user,
        ], 200);
    }

    public function update(RouteUser $request, string $id)
    {
        $routes_user = RouteUser::find($id);

        if (is_null($routes_user)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el ruta con user para actualizar!',
            ], 404);
        }

        // Validar los datos de la solicitud
        $validated = $request->validated();

        // Actualizar el ruta con los datos validados
        $routes_user->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => '¡ruta con user actualizada!',
            'data' => $routes_user,
        ], 200);
    }

    public function destroy(string $id)
    {
        $routes_user = RouteUser::find($id);

        if (is_null($routes_user)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la ruta con los users para eliminar!',
            ], 404);
        }

        $routes_user->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡ruta con los users eliminado!',
        ], 204);
    }
}
