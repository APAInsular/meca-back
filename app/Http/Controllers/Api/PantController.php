<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\PantRequest;
use App\Models\Pant;

class PantController extends Controller
{
    public function index()
    {
        $pants = Pant::all();

        if ($pants->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se encontraron pantalones!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Pantalones encontrados!',
            'data' => $pants,
        ], 200);
    }

    public function store(PantRequest $request)
    {

        $pant = Pant::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => '¡Pantalón creado exitosamente!',
            'data' => $pant,
        ], 201);
    }

    public function show(string $id)
    {
        $pant = Pant::find($id);

        if (is_null($pant)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el pantalón!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando detalles del pantalón!',
            'data' => $pant,
        ], 200);
    }

    public function update(PantRequest $request, string $id)
    {
        $pant = Pant::find($id);

        if (is_null($pant)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el pantalón para actualizar!',
            ], 404);
        }

        // Validar los datos de la solicitud
        $validated = $request->validated();

        $pant->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => '¡Pantalón actualizado!',
            'data' => $pant,
        ], 200);
    }

    public function destroy(string $id)
    {
        $pant = Pant::find($id);

        if (is_null($pant)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el pantalón para eliminar!',
            ], 404);
        }

        $pant->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Pantalón eliminado!',
        ], 204);
    }
}
