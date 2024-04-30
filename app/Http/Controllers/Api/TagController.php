<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();

        if ($tags->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se encontraron etiquetas!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Etiquetas encontradas!',
            'data' => $tags,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:tags',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 400);
        }

        $tag = Tag::create([
            'name' => $request->input('name'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => '¡Etiqueta creada exitosamente!',
            'data' => $tag,
        ], 201);
    }

    public function show(Tag $tag)
    {
        if (!$tag) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Etiqueta no encontrada!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando datos de la etiqueta!',
            'data' => $tag,
        ], 200);
    }

    public function update(Request $request, Tag $tag)
    {
        if (!$tag) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Etiqueta no encontrada!',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 400);
        }

        $tag->update([
            'name' => $request->input('name'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => '¡Etiqueta actualizada!',
            'data' => $tag,
        ], 200);
    }

    public function destroy(Tag $tag)
    {
        if (!$tag) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Etiqueta no encontrada!',
            ], 404);
        }

        $tag->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Etiqueta eliminada!',
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => '¡Ha ocurrido un error con los métodos del controlador para etiquetas!',
        ], 400);
    }
}
