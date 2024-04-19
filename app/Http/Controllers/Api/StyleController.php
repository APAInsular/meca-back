<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StyleStoreRequest;
use App\Models\Style;

class StyleController extends Controller
{
    public function index()
    {
        $styles = Style::all();

        if ($styles->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No se encontraron estilos.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Estilos encontrados.',
            'data' => $styles
        ], 200);
    }

    public function store(StyleStoreRequest $request)
    {
        $validated = $request->validated();

        $style = Style::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Estilo creado exitosamente.',
            'data' => $style
        ], 201);
    }

    public function show(Style $style)
    {
        if (!$style) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Estilo no encontrado.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detalles del estilo.',
            'data' => $style
        ], 200);
    }

    public function update(StyleStoreRequest $request, Style $style)
    {
        if (!$style) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Estilo no encontrado.'
            ], 404);
        }

        $validated = $request->validated();

        $style->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Estilo actualizado.',
            'data' => $style
        ], 200);
    }

    public function destroy(Style $style)
    {
        if (!$style) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Estilo no encontrado.'
            ], 404);
        }

        $style->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Estilo eliminado.'
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Error en los métodos del controlador para estilos.'
        ], 400);
    }
}
