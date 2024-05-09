<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function getMonumentsByAuthor($authorId)
    {
        try {
            // Busca al autor por su ID
            $author = Author::findOrFail($authorId);
            
            // Obtiene los monumentos asociados al autor
            $monuments = $author->monuments;
    
            // Retorna la respuesta JSON con los monumentos encontrados
            return response()->json([
                'status' => 'success',
                'message' => 'Monumentos del autor encontrados.',
                'data' => $monuments,
            ], 200);
        } catch (\Exception $e) {
            // Si ocurre algún error al buscar al autor, se retorna una respuesta de error
            return response()->json([
                'status' => 'error',
                'message' => 'Error al buscar los monumentos del autor.',
                'error' => $e->getMessage(),
            ], 404);
        }
    }
    



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
            'first_surname' => 'required|string|max:255',
            'second_surname' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'date_of_death' => 'nullable|date',
            'location' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|string|max:255',
            'video' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error en la validación de datos.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $author = Author::create($request->all());

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
            'first_surname' => 'required|string|max:255',
            'second_surname' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'date_of_death' => 'nullable|date',
            'location' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|string|max:255',
            'video' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error en la validación de datos.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $author->update($request->all());

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
