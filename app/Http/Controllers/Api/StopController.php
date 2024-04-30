<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StopStoreRequest;
use App\Models\Stop;

class StopController extends Controller
{
    public function index()
    {
        $stops = Stop::all();

        if ($stops->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No se encontraron paradas.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Paradas encontradas.',
            'data' => $stops
        ], 200);
    }

    public function store(StopStoreRequest $request)
    {
        $validated = $request->validated();

        $stop = Stop::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Parada creada exitosamente.',
            'data' => $stop
        ], 201);
    }

    public function show(Stop $stop)
    {
        if (!$stop) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Parada no encontrada.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detalles de la parada.',
            'data' => $stop
        ], 200);
    }

    public function update(StopStoreRequest $request, Stop $stop)
    {
        if (!$stop) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Parada no encontrada.'
            ], 404);
        }

        $validated = $request->validated();

        $stop->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Parada actualizada.',
            'data' => $stop
        ], 200);
    }

    public function destroy(Stop $stop)
    {
        if (!$stop) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Parada no encontrada.'
            ], 404);
        }

        $stop->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Parada eliminada.'
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Error en los métodos del controlador para paradas.'
        ], 400);
    }
}
