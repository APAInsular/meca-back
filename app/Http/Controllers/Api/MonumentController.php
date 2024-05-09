<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Monument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MonumentController extends Controller
{
    public function allMonumentInfo()
    {
        $query = "
            SELECT 
                m.id AS monument_id,
                m.title AS monument_title,
                m.type AS monument_type,
                m.creation_date AS monument_creation_date,
                m.main_image AS monument_main_image,
                m.latitude AS monument_latitude,
                m.longitude AS monument_longitude,
                m.meaning AS monument_meaning,
                JSON_ARRAYAGG(JSON_OBJECT('id', a.id, 'name', a.name)) AS authors,
                GROUP_CONCAT(s.name) AS styles,
                (
                    SELECT COUNT(rating)
                    FROM ratings r
                    WHERE r.rateable_id = m.id
                ) AS total_ratings,
                (
                    SELECT ROUND(COALESCE(AVG(rating), 0), 2)
                    FROM ratings r
                    WHERE r.rateable_id = m.id
                ) AS average_rating
            FROM 
                monuments m
            LEFT JOIN 
                author_monument am ON m.id = am.monument_id
            LEFT JOIN 
                authors a ON am.author_id = a.id
            LEFT JOIN 
                monument_style ms ON m.id = ms.monument_id
            LEFT JOIN 
                styles s ON ms.style_id = s.id
            GROUP BY 
                m.id
        ";

        $monuments = DB::select($query);

        $result = collect($monuments)->map(function ($monument) {
            $authors = json_decode($monument->authors, true);
            $authors = array_map(function ($author) {
                return [
                    'id' => $author['id'],
                    'name' => $author['name']
                ];
            }, $authors);

            return [
                'id' => $monument->monument_id,
                'title' => $monument->monument_title,
                'type' => $monument->monument_type,
                'creation_date' => $monument->monument_creation_date,
                'main_image' => $monument->monument_main_image,
                'latitude' => $monument->monument_latitude,
                'longitude' => $monument->monument_longitude,
                'meaning' => $monument->monument_meaning,
                'authors' => $authors,
                'styles' => $monument->styles ? explode(',', $monument->styles) : [],
                'total_ratings' => $monument->total_ratings,
                'average_rating' => $monument->average_rating,
            ];
        });

        return $result;
    }



    public function findMonumentById($id)
    {
        $monument = Monument::select(
            'monuments.id',
            'monuments.title as name',
            'monuments.meaning as description',
            'monuments.address_id as location',
            'monuments.created_at',
            'monuments.updated_at'
        )
            ->leftJoin('monument_style', 'monuments.id', '=', 'monument_style.monument_id')
            ->leftJoin('styles', 'monument_style.style_id', '=', 'styles.id')
            ->leftJoin('author_monument', 'monuments.id', '=', 'author_monument.monument_id')
            ->leftJoin('authors', 'author_monument.author_id', '=', 'authors.id')
            ->where('monuments.id', $id)
            ->groupBy('monuments.id', 'monuments.title', 'monuments.meaning', 'monuments.address_id', 'monuments.created_at', 'monuments.updated_at')
            ->first(['monuments.*', 'styles.name as style', 'authors.name as author']);

        if (!$monument) {
            return response()->json([
                'status' => 'error',
                'message' => 'Monumento no encontrado.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Información del monumento encontrada.',
            'data' => $monument
        ], 200);
    }

    public function index()
    {
        $monuments = Monument::all();

        if ($monuments->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se encontraron monumentos!',
                'data' => [],
            ], 404);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => '¡Monumentos encontrados!',
                'data' => $monuments,
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'creation_date' => 'required|date',
            'main_image' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'meaning' => 'nullable|string',
            'style_id' => 'required|exists:styles,id',
            'q_r_id' => 'required|exists:q_r,id',
            'address_id' => 'required|exists:addresses,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 400);
        }

        $monument = Monument::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => '¡Monumento creado exitosamente!',
            'data' => $monument,
        ], 201);
    }

    public function show(Monument $monument)
    {
        if (!$monument) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Monumento no encontrado!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando datos del monumento!',
            'data' => $monument,
        ], 200);
    }

    public function update(Request $request, Monument $monument)
    {
        if (!$monument) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Monumento no encontrado!',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'creation_date' => 'required|date',
            'main_image' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'meaning' => 'nullable|string',
            'style_id' => 'required|exists:styles,id',
            'q_r_id' => 'required|exists:q_r,id',
            'address_id' => 'required|exists:addresses,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 400);
        }

        $monument->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => '¡Monumento actualizado!',
            'data' => $monument,
        ], 200);
    }

    public function destroy(Monument $monument)
    {
        if (!$monument) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Monumento no encontrado!',
            ], 404);
        }

        $monument->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Monumento eliminado!',
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => '¡Ha ocurrido un error con los métodos del controlador para monumentos!',
        ], 400);
    }
}
