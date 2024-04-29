<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RatingStoreRequest;
use App\Models\Rating;

class RouteController extends Controller
{
    public function index()
    {
        $ratings = Rating::all();

        if ($ratings->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No se encontraron calificaciones.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Calificaciones encontradas.',
            'data' => $ratings
        ], 200);
    }

    public function store(RatingStoreRequest $request)
    {
        $validated = $request->validated();

        $rating = Rating::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Calificación creada exitosamente.',
            'data' => $rating
        ], 201);
    }

    public function show(Rating $rating)
    {
        if (!$rating) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Calificación no encontrada.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detalles de la calificación.',
            'data' => $rating
        ], 200);
    }

    public function update(RatingStoreRequest $request, Rating $rating)
    {
        if (!$rating) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Calificación no encontrada.'
            ], 404);
        }

        $validated = $request->validated();

        $rating->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Calificación actualizada.',
            'data' => $rating
        ], 200);
    }

    public function destroy(Rating $rating)
    {
        if (!$rating) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Calificación no encontrada.'
            ], 404);
        }

        $rating->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Calificación eliminada.'
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Error en los métodos del controlador para calificaciones.'
        ], 400);
    }
}
