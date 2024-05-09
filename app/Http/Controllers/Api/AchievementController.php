<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AchievementStoreRequest;
use App\Models\Achievement;


class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::all();

        if ($achievements->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se Encontraron Logros!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Logros Encontrados!',
            'data' => $achievements,
        ], 200);
    }

    public function store(AchievementStoreRequest $request)
    {
        $achievement = Achievement::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => '¡Logro Creado Exitosamente!',
            'data' => $achievement,
        ], 201);
    }

    public function show(Achievement $achievement)
    {
        if (is_null($achievement)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el Logro!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '!Mostrando Datos del Logro!',
            'data' => $achievement,
        ], 200);
    }

    public function update(Achievement $achievement)
    {
        if (is_null($achievement)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el Logro para Actualizar!',
            ], 404);
        }

        $achievement->update([]);

        return response()->json([
            'status' => 'success',
            'message' => '¡Logro Actualizado!',
            'data' => $achievement,
        ], 200);
    }

    public function destroy(Achievement $achievement)
    {
        if (is_null($achievement)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el Logro para Eliminar!',
            ], 404);
        }

        $achievement->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Logro Eliminado!',
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => '¡Ha Ocurrido un Error con los Métodos del Controlador para Logros!',
        ], 400);
    }
}
