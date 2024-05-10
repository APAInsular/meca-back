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

    public function findMonumentById(Request $request, $monumentId)
    {
        $userId = $request->userId;

        // Obtener la información básica del monumento
        $monument = DB::table('Monuments')->where('id', $monumentId)->first();

        // Obtener los autores asociados al monumento
        $authors = DB::table('Authors')
            ->join('author_monument', 'Authors.id', '=', 'author_monument.author_id')
            ->where('author_monument.monument_id', $monumentId)
            ->select('Authors.id', 'Authors.name')
            ->get();

        // Obtener los estilos asociados al monumento
        $styles = DB::table('Styles')
            ->join('monument_style', 'Styles.id', '=', 'monument_style.style_id')
            ->where('monument_style.monument_id', $monumentId)
            ->select('Styles.id', 'Styles.name')
            ->get();

        // Obtener los comentarios asociados al monumento, incluyendo información completa de los usuarios y likes
        $comments = DB::table('Comments')
            ->join('Users', 'Comments.user_id', '=', 'Users.id')
            ->leftJoin('likes', function ($join) {
                $join->on('Comments.id', '=', 'likes.likable_id')
                    ->where('likes.likable_type', '=', 'Comment');
            })
            ->where('Comments.commentable_id', $monumentId)
            ->where('Comments.commentable_type', 'Monument')
            ->select(
                'Comments.id',
                'Comments.content',
                'Comments.created_at',
                'Users.nickname',
                'Users.profile_picture',
                DB::raw('COUNT(likes.id) as total_likes')
            )
            ->groupBy('Comments.id')
            ->get();

        // Obtener la información de los likes de cada comentario
        foreach ($comments as $comment) {
            // Verificar si el usuario ha dado "me gusta" al comentario actual
            $userLike = DB::table('likes')
                ->where('likable_id', $comment->id)
                ->where('likable_type', 'Comment')
                ->where('user_id', $userId)
                ->first(); // Obtener la primera coincidencia si existe

            // Estructurar los likes como objetos de usuario
            $comment->likes = DB::table('likes')
                ->where('likable_id', $comment->id)
                ->where('likable_type', 'Comment')
                ->join('Users', 'likes.user_id', '=', 'Users.id')
                ->select('likes.id', 'Users.id as user_id', 'Users.nickname', 'Users.profile_picture')
                ->get();

            // Estructurar el usuario del comentario como un objeto de usuario
            $comment->user = [
                'id' => $comment->id,
                'nickname' => $comment->nickname,
                'profile_picture' => $comment->profile_picture
                // Agrega aquí cualquier otro campo de usuario que desees incluir
            ];

            // Agregar la propiedad user_like al comentario con el ID del like y del usuario
            $comment->user_like = $userLike ? (object)[
                'value' => true,
                'like_id' => $userLike->id,
                'user_id' => $userLike->user_id
            ] : (object)['value' => false];
        }


        // Construir el arreglo final con el formato requerido
        $response = [
            'id' => $monument->id,
            'title' => $monument->title,
            'type' => $monument->type,
            'creation_date' => $monument->creation_date,
            'main_image' => $monument->main_image,
            'latitude' => $monument->latitude,
            'longitude' => $monument->longitude,
            'meaning' => $monument->meaning,
            'authors' => $authors,
            'styles' => $styles,
            'comments' => $comments,
            // Aquí puedes agregar cualquier otra información que necesites del monumento
        ];

        return response()->json($response);
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
