<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\SexRequest;
use App\Models\Sex;

class SexController extends Controller
{
    public function index()
    {
        $sexes = Sex::all();

        return response()->json([
            'status' => 'success',
            'message' => '¡Sexos encontrados!',
            'data' => $sexes,
        ], 200);
    }

    public function store(SexRequest $request)
    {

        $sex = Sex::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => '¡Sexo creado exitosamente!',
            'data' => $sex,
        ], 201);
    }

    public function show(string $id)
    {
        $sex = Sex::find($id);

        if (is_null($sex)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el sexo!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando detalles del sexo!',
            'data' => $sex,
        ], 200);
    }

    public function update(SexRequest $request, string $id)
    {
        $sex = Sex::find($id);

        if (is_null($sex)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el sexo para actualizar!',
            ], 404);
        }

        // Validar los datos de la solicitud
        $validated = $request->validated();

        $sex->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => '¡Sexo actualizado!',
            'data' => $sex,
        ], 200);
    }

    public function destroy(string $id)
    {
        $sex = Sex::find($id);

        if (is_null($sex)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el sexo para eliminar!',
            ], 404);
        }

        $sex->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Sexo eliminado!',
        ], 204);
    }
}
