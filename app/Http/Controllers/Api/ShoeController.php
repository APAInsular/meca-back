<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\ShoeRequest;
use App\Models\Shoe;

class ShoeController extends Controller
{
    public function index()
    {
        $shoes = Shoe::all();

        return response()->json([
            'status' => 'success',
            'message' => '¡Zapatos encontrados!',
            'data' => $shoes,
        ], 200);
    }

    public function store(ShoeRequest $request)
    {

        $shoe = Shoe::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => '¡Zapato creado exitosamente!',
            'data' => $shoe,
        ], 201);
    }

    public function show(string $id)
    {
        $shoe = Shoe::find($id);

        if (is_null($shoe)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el zapato!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando detalles del zapato!',
            'data' => $shoe,
        ], 200);
    }

    public function update(ShoeRequest $request, string $id)
    {
        $shoe = Shoe::find($id);

        if (is_null($shoe)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el zapato para actualizar!',
            ], 404);
        }

        // Validar los datos de la solicitud
        $validated = $request->validated();

        $shoe->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => '¡Zapato actualizado!',
            'data' => $shoe,
        ], 200);
    }

    public function destroy(string $id)
    {
        $shoe = Shoe::find($id);

        if (is_null($shoe)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el zapato para eliminar!',
            ], 404);
        }

        $shoe->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Zapato eliminado!',
        ], 204);
    }
}
