<?php

namespace App\Http\Controllers;

use App\Http\Requests\BodyRequest;
use Illuminate\Http\Request;
use App\Models\Body;

class BodyController extends Controller
{
    public function index()
    {
        $bodies = Body::all();

        if ($bodies->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se encontraron cuerpos!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Cuerpos encontrados!',
            'data' => $bodies,
        ], 200);
    }

    public function store(BodyRequest $request)
    {


        $body = Body::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => '¡Cuerpo creado exitosamente!',
            'data' => $body,
        ], 201);
    }


    public function show(string $id)
    {
        $body = Body::find($id);

        if (is_null($body)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el cuerpo!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando detalles del cuerpo!',
            'data' => $body,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $body = Body::find($id);

        if (is_null($body)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el cuerpo para actualizar!',
            ], 404);
        }

        // Validar los datos de la solicitud
        $validated = $request->validated();

        $body->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => '¡Cuerpo actualizado!',
            'data' => $body,
        ], 200);
    }

    public function destroy(string $id)
    {
        $body = Body::find($id);

        if (is_null($body)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el cuerpo para eliminar!',
            ], 404);
        }

        $body->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Cuerpo eliminado!',
        ], 204);
    }
}
