<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BlogEntryStoreRequest;
use App\Models\BlogEntry;

class BlogEntryController extends Controller
{
    public function index()
    {
        $blogEntries = BlogEntry::all();

        if ($blogEntries->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se Encontraron Entradas de Blog!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Entradas de Blog Encontradas!',
            'data' => $blogEntries,
        ], 200);
    }

    public function store(BlogEntryStoreRequest $request)
    {
        $blogEntry = BlogEntry::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => '¡Entrada de Blog Creada Exitosamente!',
            'data' => $blogEntry,
        ], 201);
    }

    public function show(BlogEntry $blogEntry)
    {
        if (is_null($blogEntry)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la Entrada de Blog!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '!Mostrando Datos de la Entrada de Blog!',
            'data' => $blogEntry,
        ], 200);
    }

    public function update(BlogEntry $blogEntry)
    {
        if (is_null($blogEntry)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la Entrada de Blog para Actualizar!',
            ], 404);
        }

        $blogEntry->update([]);

        return response()->json([
            'status' => 'success',
            'message' => '¡Entrada de Blog Actualizada!',
            'data' => $blogEntry,
        ], 200);
    }

    public function destroy(BlogEntry $blogEntry)
    {
        if (is_null($blogEntry)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la Entrada de Blog para Eliminar!',
            ], 404);
        }

        $blogEntry->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Entrada de Blog Eliminada!',
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => '¡Ha Ocurrido un Error con los Métodos del Controlador para Entradas de Blog!',
        ], 400);
    }
}
