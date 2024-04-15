<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddressStoreRequest;
use App\Models\Address;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::all();

        if ($addresses->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se Encontraron Direcciones!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Direcciones Encontradas!',
            'data' => $addresses,
        ], 200);
    }

    public function store(AddressStoreRequest $request)
    {
        $address = Address::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => '¡Dirección Creada Exitosamente!',
            'data' => $address,
        ], 201);
    }

    public function show(Address $address)
    {
        if (is_null($address)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la Dirección!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '!Mostrando Datos de la Dirección!',
            'data' => $address,
        ], 200);
    }

    public function update(Address $address)
    {
        if (is_null($address)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la Dirección para Actualizar!',
            ], 404);
        }

        $address->update([]);

        return response()->json([
            'status' => 'success',
            'message' => '¡Dirección Actualizada!',
            'data' => $address,
        ], 200);
    }

    public function destroy(Address $address)
    {
        if (is_null($address)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la Dirección para Eliminar!',
            ], 404);
        }

        $address->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Dirección Eliminada!',
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => '¡Ha Ocurrido un Error con los Métodos del Controlador para Direcciones!',
        ], 400);
    }
}
