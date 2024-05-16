<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AccessoryRequest;
use Illuminate\Http\Request;
use App\Models\Accessory;

class AccessoryController extends Controller
{
    public function index()
    {
        $accessories = Accessory::all();

        if ($accessories->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se encontraron accesorios!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Accesorios encontrados!',
            'data' => $accessories,
        ], 200);
    }

    public function store(AccessoryRequest $request)
    {

        $accessory = Accessory::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => '¡Accesorio creado exitosamente!',
            'data' => $accessory,
        ], 201);
    }

    public function show(string $id)
    {
        $accessory = Accessory::find($id);

        if (is_null($accessory)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el accesorio!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando detalles del accesorio!',
            'data' => $accessory,
        ], 200);
    }

    public function update(AccessoryRequest $request, string $id)
    {
        $accessory = Accessory::find($id);

        if (is_null($accessory)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el accesorio para actualizar!',
            ], 404);
        }

        // Validar los datos de la solicitud
        $validated = $request->validated();

        // Actualizar el accesorio con los datos validados
        $accessory->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => '¡Accesorio actualizado!',
            'data' => $accessory,
        ], 200);
    }

    public function destroy(string $id)
    {
        $accessory = Accessory::find($id);

        if (is_null($accessory)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el accesorio para eliminar!',
            ], 404);
        }

        $accessory->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Accesorio eliminado!',
        ], 204);
    }
}
