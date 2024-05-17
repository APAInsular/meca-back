<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\HairRequest;
use Illuminate\Http\Request;
use App\Models\Hair;

class HairController extends Controller
{
    public function index()
    {
        $hairs = Hair::all();

        if ($hairs->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se encontraron tipos de cabello!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Tipos de cabello encontrados!',
            'data' => $hairs,
        ], 200);
    }

    public function store(HairRequest $request)
    {

        $hair = Hair::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => '¡Tipo de cabello creado exitosamente!',
            'data' => $hair,
        ], 201);
    }

    public function show(string $id)
    {
        $hair = Hair::find($id);

        if (is_null($hair)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el tipo de cabello!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando detalles del tipo de cabello!',
            'data' => $hair,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $hair = Hair::find($id);

        if (is_null($hair)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el tipo de cabello para actualizar!',
            ], 404);
        }

        // Validar los datos de la solicitud
        $validated = $request->validated();

        $hair->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => '¡Tipo de cabello actualizado!',
            'data' => $hair,
        ], 200);
    }

    public function destroy(string $id)
    {
        $hair = Hair::find($id);

        if (is_null($hair)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el tipo de cabello para eliminar!',
            ], 404);
        }

        $hair->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Tipo de cabello eliminado!',
        ], 204);
    }
}
