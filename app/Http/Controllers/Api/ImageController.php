<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\imagestoreRequest;
use App\Models\Image;

class ImageController extends Controller
{
    public function index()
    {
        $images = image::with('images')->get();

        if ($images->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No se encontraron images.',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'images encontrados exitosamente.',
            'data' => $images,
        ], 200);
    }

    public function store(imageStoreRequest $request)
    {
        $validatedData = $request->validated();

        $image = image::create($validatedData);

        // Si hay imágenes asociadas, las almacenamos
        if ($request->has('images')) {
            $images = [];
            foreach ($validatedData['images'] as $imageUrl) {
                $images[] = new Image(['url' => $imageUrl]);
            }
            $image->images()->saveMany($images);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'image creado exitosamente.',
            'data' => $image,
        ], 201);
    }

    public function show(image $image)
    {
        $image->load('images');

        if (!$image) {
            return response()->json([
                'status' => 'failed',
                'message' => 'images no encontrado.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detalles del images mostrados exitosamente.',
            'data' => $image,
        ], 200);
    }

    public function update(imagestoreRequest $request, image $image)
    {
        if (!$image) {
            return response()->json([
                'status' => 'failed',
                'message' => 'images no encontrado para actualizar.',
            ], 404);
        }

        $validatedData = $request->validated();

        $image->update($validatedData);

        // Actualizamos las imágenes asociadas si es necesario
        if ($request->has('images')) {
            $image->images()->delete(); // Borramos las imágenes anteriores
            $images = [];
            foreach ($validatedData['images'] as $imageUrl) {
                $images[] = new Image(['url' => $imageUrl]);
            }
            $image->images()->saveMany($images);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'images actualizado exitosamente.',
            'data' => $image,
        ], 200);
    }

    public function destroy(image $image)
    {
        if (!$image) {
            return response()->json([
                'status' => 'failed',
                'message' => 'images no encontrado para eliminar.',
            ], 404);
        }

        $image->images()->delete(); // Borramos las imágenes asociadas
        $image->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'images eliminado exitosamente.',
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Ocurrió un error al procesar la solicitud de imagess.',
        ], 400);
    }
}
