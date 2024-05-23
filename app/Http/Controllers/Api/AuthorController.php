<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function getMonumentsByAuthor($authorId)
    {
        $monuments = DB::table('author_monument')
            ->join('authors', 'author_monument.author_id', '=', 'authors.id')
            ->join('monuments', 'author_monument.monument_id', '=', 'monuments.id')
            ->where('authors.id', $authorId)
            ->select('monuments.*')
            ->get();

        return response()->json($monuments);
    }

    public function getTopRatedAuthors()
    {
        $topAuthors = DB::table('authors')
            ->select(
                'authors.id',
                'authors.name',
                'authors.first_surname',
                'authors.second_surname',
                'authors.date_of_birth',
                'authors.date_of_death',
                'authors.description',
                DB::raw('COUNT(author_monument.monument_id) AS monument_count'),
                DB::raw('ROUND(COALESCE(AVG(ratings.rating), 0), 2) AS avg_rating')
            )
            ->leftJoin('author_monument', 'authors.id', '=', 'author_monument.author_id')
            ->leftJoin('monuments', 'author_monument.monument_id', '=', 'monuments.id')
            ->leftJoin('ratings', function ($join) {
                $join->on('monuments.id', '=', 'ratings.rateable_id')
                    ->where('ratings.rateable_type', '=', 'App\\Models\\Monument');
            })
            ->groupBy(
                'authors.id',
                'authors.name',
                'authors.first_surname',
                'authors.second_surname',
                'authors.date_of_birth',
                'authors.date_of_death',
                'authors.description'
            )
            ->orderBy('avg_rating', 'DESC')
            ->limit(4)
            ->get();

        return $topAuthors;
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
