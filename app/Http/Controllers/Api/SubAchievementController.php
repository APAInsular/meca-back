<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SubAchievementStoreRequest;
use App\Models\SubAchievement;

class SubAchievementController extends Controller
{
    public function index()
    {
        $subAchievements = SubAchievement::all();

        if ($subAchievements->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No se encontraron sub-logros.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Sub-logros encontrados.',
            'data' => $subAchievements
        ], 200);
    }

    public function store(SubAchievementStoreRequest $request)
    {
        $validated = $request->validated();

        $subAchievement = SubAchievement::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Sub-logro creado exitosamente.',
            'data' => $subAchievement
        ], 201);
    }

    public function show(SubAchievement $subAchievement)
    {
        if (!$subAchievement) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Sub-logro no encontrado.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detalles del sub-logro.',
            'data' => $subAchievement
        ], 200);
    }

    public function update(SubAchievementStoreRequest $request, SubAchievement $subAchievement)
    {
        if (!$subAchievement) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Sub-logro no encontrado.'
            ], 404);
        }

        $validated = $request->validated();

        $subAchievement->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Sub-logro actualizado.',
            'data' => $subAchievement
        ], 200);
    }

    public function destroy(SubAchievement $subAchievement)
    {
        if (!$subAchievement) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Sub-logro no encontrado.'
            ], 404);
        }

        $subAchievement->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Sub-logro eliminado.'
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Error en los métodos del controlador para sub-logros.'
        ], 400);
    }
}
