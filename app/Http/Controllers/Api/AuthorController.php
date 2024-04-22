<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();

        if ($authors->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No se encontraron autores.',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Autores encontrados.',
            'data' => $authors,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error en la validación de datos.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $author = Author::create($request->only('name'));

        return response()->json([
            'status' => 'success',
            'message' => 'Autor creado exitosamente.',
            'data' => $author,
        ], 201);
    }

    public function show(Author $author)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Mostrando detalles del autor.',
            'data' => $author,
        ], 200);
    }

    public function update(Request $request, Author $author)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error en la validación de datos.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $author->update($request->only('name'));

        return response()->json([
            'status' => 'success',
            'message' => 'Autor actualizado exitosamente.',
            'data' => $author,
        ], 200);
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Autor eliminado exitosamente.',
        ], 204);
    }
}
