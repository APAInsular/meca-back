<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\TshirtRequest;
use Illuminate\Http\Request;
use App\Models\Tshirt;

class TshirtController extends Controller
{
    public function index()
    {
        $tshirts = Tshirt::all();

        return response()->json([
            'status' => 'success',
            'message' => '¡Camisetas encontradas!',
            'data' => $tshirts,
        ], 200);
    }

    public function store(TshirtRequest $request)
    {

        $tshirt = Tshirt::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => '¡Camiseta creada exitosamente!',
            'data' => $tshirt,
        ], 201);
    }

    public function show(string $id)
    {
        $tshirt = Tshirt::find($id);

        if (is_null($tshirt)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la camiseta!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando detalles de la camiseta!',
            'data' => $tshirt,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $tshirt = Tshirt::find($id);

        if (is_null($tshirt)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la camiseta para actualizar!',
            ], 404);
        }

        // Validar los datos de la solicitud
        $validated = $request->validated();

        $tshirt->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => '¡Camiseta actualizada!',
            'data' => $tshirt,
        ], 200);
    }

    public function destroy(string $id)
    {
        $tshirt = Tshirt::find($id);

        if (is_null($tshirt)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la camiseta para eliminar!',
            ], 404);
        }

        $tshirt->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Camiseta eliminada!',
        ], 204);
    }
}
