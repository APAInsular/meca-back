<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoryStoreRequest;
use App\Models\Category;

class CalificationController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se encontraron categorías!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Categorías encontradas!',
            'data' => $categories,
        ], 200);
    }

    public function store(CategoryStoreRequest $request)
    {
        $validated = $request->validated();

        $category = Category::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => '¡Categoría creada exitosamente!',
            'data' => $category,
        ], 201);
    }

    public function show(Category $category)
    {
        if (is_null($category)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la categoría!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando detalles de la categoría!',
            'data' => $category,
        ], 200);
    }

    public function update(CategoryStoreRequest $request, Category $category)
    {
        if (is_null($category)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la categoría para actualizar!',
            ], 404);
        }

        $validated = $request->validated();

        $category->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => '¡Categoría actualizada!',
            'data' => $category,
        ], 200);
    }

    public function destroy(Category $category)
    {
        if (is_null($category)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la categoría para eliminar!',
            ], 404);
        }

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Categoría eliminada!',
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => '¡Ha ocurrido un error con los métodos del controlador para categorías!',
        ], 400);
    }
}
