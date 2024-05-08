<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Monument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MonumentController extends Controller
{
    public function allMonumentInfo(Request $request)
    {
        $user_id = $request->query('user_id');

        // Obtener todos los monumentos con sus autores, estilos y calificaciones
        $monuments = Monument::with(['authors', 'style', 'ratings'])
            ->withCount('ratings')
            ->get();

        // Filtrar las calificaciones del usuario específico y calcular la media de las calificaciones para cada monumento
        $monuments->each(function ($monument) use ($user_id) {
            if ($monument != null) {
                $user_rating = $monument->ratings->first(function ($rating) use ($user_id, $monument) {
                    return (
                        $rating->rateable_type == Monument::class &&
                        $rating->rateable_id == $monument->id &&
                        $rating->user_id == $user_id
                    );
                });

                // Calcular la suma de todas las calificaciones para este monumento
                $total_points = $monument->ratings->sum('rating');
                // Contar el número total de calificaciones
                $total_ratings = $monument->ratings->count();
                // Calcular el promedio
                $average_rating = $total_ratings > 0 ? $total_points / $total_ratings : 0;
            } else {
                $total_ratings = 0;
                $average_rating = 0;
            }

            // Establecer las propiedades en el monumento
            $monument->average_rating = $average_rating;
            $monument->has_liked = $user_rating !== null;
            $monument->user_rating = $user_rating ? $user_rating->rating : null;
        });

        return $monuments;
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
