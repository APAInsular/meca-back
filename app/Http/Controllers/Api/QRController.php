<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\QRStoreRequest;
use App\Models\QR;

class QRController extends Controller
{
    public function index()
    {
        $qrs = QR::all();

        if ($qrs->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No se encontraron códigos QR.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Códigos QR encontrados.',
            'data' => $qrs
        ], 200);
    }

    public function store(QRStoreRequest $request)
    {
        $validated = $request->validated();

        $qr = QR::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Código QR creado exitosamente.',
            'data' => $qr
        ], 201);
    }

    public function show(QR $qr)
    {
        if (!$qr) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Código QR no encontrado.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detalles del código QR.',
            'data' => $qr
        ], 200);
    }

    public function update(QRStoreRequest $request, QR $qr)
    {
        $validated = $request->validated();

        $qr->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Código QR actualizado.',
            'data' => $qr
        ], 200);
    }

    public function destroy(QR $qr)
    {
        if (!$qr) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Código QR no encontrado.'
            ], 404);
        }

        $qr->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Código QR eliminado.'
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Error en los métodos del controlador para códigos QR.'
        ], 400);
    }
}
