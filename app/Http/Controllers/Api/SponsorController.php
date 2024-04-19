<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SponsorStoreRequest;
use App\Models\Sponsor;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::all();

        if ($sponsors->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No se encontraron patrocinadores.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Patrocinadores encontrados.',
            'data' => $sponsors
        ], 200);
    }

    public function store(SponsorStoreRequest $request)
    {
        $validated = $request->validated();

        $sponsor = Sponsor::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Patrocinador creado exitosamente.',
            'data' => $sponsor
        ], 201);
    }

    public function show(Sponsor $sponsor)
    {
        if (!$sponsor) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Patrocinador no encontrado.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detalles del patrocinador.',
            'data' => $sponsor
        ], 200);
    }

    public function update(SponsorStoreRequest $request, Sponsor $sponsor)
    {
        if (!$sponsor) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Patrocinador no encontrado.'
            ], 404);
        }

        $validated = $request->validated();

        $sponsor->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Patrocinador actualizado.',
            'data' => $sponsor
        ], 200);
    }

    public function destroy(Sponsor $sponsor)
    {
        if (!$sponsor) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Patrocinador no encontrado.'
            ], 404);
        }

        $sponsor->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Patrocinador eliminado.'
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Error en los métodos del controlador para patrocinadores.'
        ], 400);
    }
}
