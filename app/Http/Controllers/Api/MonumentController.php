<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Monument;
use App\Models\MonumentUser;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MonumentController extends Controller
{

    public function filterMonuments(Request $request, $page = 1)
    {
        $query = DB::table('monuments')
            ->leftJoin('ratings', function ($join) {
                $join->on('monuments.id', '=', 'ratings.rateable_id')
                    ->where('ratings.rateable_type', 'Monument');
            })
            ->leftJoin('author_monument', 'monuments.id', '=', 'author_monument.monument_id')
            ->leftJoin('authors', 'authors.id', '=', 'author_monument.author_id')
            ->leftJoin('styles', 'monuments.style_id', '=', 'styles.id')
            ->leftJoin('addresses', 'monuments.address_id', '=', 'addresses.id')
            ->select('monuments.*', 'styles.name as style_name', 'addresses.location', 'authors.name as author_name', DB::raw('AVG(ratings.rating) as average_rating'))
            ->groupBy('monuments.id', 'styles.name', 'addresses.location', 'authors.name');

        if ($request->has('location')) {
            $query->where('addresses.location', 'like', '%' . $request->location . '%');
        }
        if ($request->has('style_id')) {
            $query->where('monuments.style_id', $request->style_id);
        }
        if ($request->has('author_id')) {
            $query->where('authors.id', $request->author_id);
        }
        if ($request->has('creation_year')) {
            $query->whereYear('monuments.creation_date', $request->creation_year);
        }
        if ($request->has('rating')) {
            $query->having('average_rating', '>=', $request->rating);
        }

        $monuments = $query->paginate(20, ['*'], 'page', $page);

        return response()->json([
            'status' => 'success',
            'message' => 'Filtered monuments retrieved successfully',
            'data' => $monuments,
        ], 200);
    }

    public function allMonumentInfo()
    {
        $monuments = Monument::with(['authors', 'styles'])
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->get();

        $result = $monuments->map(function ($monument) {
            return [
                'id' => $monument->id,
                'title' => $monument->title,
                'type' => $monument->type,
                'creation_date' => $monument->creation_date,
                'main_image' => $monument->main_image,
                'latitude' => $monument->latitude,
                'longitude' => $monument->longitude,
                'meaning' => $monument->meaning,
                'authors' => $monument->authors->map(function ($author) {
                    return [
                        'id' => $author->id,
                        'name' => $author->name
                    ];
                }),
                'styles' => $monument->styles->pluck('name')->toArray(),
                'total_ratings' => $monument->ratings_count,
                'average_rating' => round($monument->ratings_avg, 2),
            ];
        });

        return $result;
    }

    public function findMonumentById(Request $request, $monumentId)
    {
        $userId = $request->userId;

        // Obtener la información básica del monumento junto con los ratings usando Eloquent
        $monument = Monument::withCount(['ratings as total_ratings'])
            ->withAvg('ratings as average_rating', 'rating')
            ->where('id', $monumentId)
            ->first();

        if (!$monument) {
            return response()->json(['message' => 'Monument not found'], 404);
        }

        // Obtener los autores asociados al monumento
        $authors = $monument->authors()->select(
            'authors.id',
            'authors.name',
            'authors.first_surname',
            'authors.second_surname',
            'authors.date_of_birth',
            'authors.date_of_death',
            'authors.description'
        )->get();

        // Obtener los estilos asociados al monumento
        $styles = $monument->styles()->select('styles.id', 'styles.name')->get();

        // Obtener los comentarios asociados al monumento, incluyendo información completa de los usuarios y likes
        $comments = $monument->comments()
            ->with(['user:id,nickname,profile_picture', 'likes' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->withCount('likes')
            ->get()
            ->map(function ($comment) use ($userId) {
                $userLike = $comment->likes->firstWhere('user_id', $userId);
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at,
                    'nickname' => $comment->user->nickname,
                    'profile_picture' => $comment->user->profile_picture,
                    'total_likes' => $comment->likes_count,
                    'likes' => $comment->likes->map(function ($like) {
                        return [
                            'id' => $like->id,
                            'user_id' => $like->user_id,
                            'nickname' => $like->user->nickname,
                            'profile_picture' => $like->user->profile_picture,
                        ];
                    }),
                    'user' => [
                        'id' => $comment->user->id,
                        'nickname' => $comment->user->nickname,
                        'profile_picture' => $comment->user->profile_picture
                    ],
                    'user_like' => $userLike ? (object)[
                        'value' => true,
                        'like_id' => $userLike->id,
                        'user_id' => $userLike->user_id
                    ] : (object)['value' => false]
                ];
            });

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
            'total_ratings' => $monument->total_ratings,
            'average_rating' => round($monument->average_rating, 2),
            'authors' => $authors,
            'styles' => $styles,
            'comments' => $comments,
        ];

        return response()->json($response);
    }

    public function checkQrAndUpdatePoints(Request $request, $userId, $monumentId)
    {
        // Buscar la última entrada en la tabla user_monument para este usuario y monumento
        $lastEntry = MonumentUser::where('user_id', $userId)
            ->where('monument_id', $monumentId)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastEntry) {
            // Calcular la diferencia de tiempo entre la última entrada y ahora
            $now = Carbon::now();
            $lastEntryDate = Carbon::parse($lastEntry->created_at);
            $hoursDifference = $now->diffInHours($lastEntryDate);

            if ($hoursDifference < 24) {
                return response()->json([
                    'success' => false,
                    'message' => 'No han pasado 24 horas desde la última vez que escaneaste este QR.'
                ]);
            }
        }

        // Si no hay entradas anteriores o han pasado más de 24 horas, crear una nueva entrada
        MonumentUser::create([
            'user_id' => $userId,
            'monument_id' => $monumentId,
        ]);

        // Actualizar los puntos del usuario
        $user = User::find($userId);
        if ($user) {
            $user->points += 50; // Aumentar los puntos en 50
            $user->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Puntos añadidos al usuario.'
        ]);
    }

    public function getTopRatedMonuments()
    {
        $topMonuments = DB::table('monuments')
            ->select(
                'monuments.*',
                DB::raw('ROUND(COALESCE(AVG(ratings.rating), 0), 2) AS avg_rating'),
                DB::raw('JSON_ARRAYAGG(
                JSON_OBJECT(
                    "id", authors.id,
                    "name", authors.name
                )
            ) AS authors')
            )
            ->leftJoin('ratings', function ($join) {
                $join->on('monuments.id', '=', 'ratings.rateable_id')
                    ->where('ratings.rateable_type', '=', 'App\Models\Monument');
            })
            ->leftJoin('author_monument', 'monuments.id', '=', 'author_monument.monument_id')
            ->leftJoin('authors', 'author_monument.author_id', '=', 'authors.id')
            ->groupBy('monuments.id')
            ->orderBy('avg_rating', 'DESC')
            ->limit(4)
            ->get();

        // Decodificar el JSON en cada fila de $topMonuments y eliminar entradas de autores duplicados
        foreach ($topMonuments as $monument) {
            $monument->authors = json_decode($monument->authors);
            // Eliminar duplicados usando una combinación de array_values y array_unique
            $monument->authors = array_values(array_unique($monument->authors, SORT_REGULAR));
        }

        return $topMonuments;
    }

    public function filterByLocality(Request $request)
    {
        $locality = $request->input('locality');

        // Consulta SQL para obtener los monumentos por localidad
        $monuments = DB::select(
            'SELECT monuments.* 
            FROM monuments
            INNER JOIN addresses ON monuments.address_id = addresses.id
            WHERE addresses.city = ?',
            [$locality]
        );

        if (empty($monuments)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No se encontraron obras en la localidad especificada',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Obras encontradas en la localidad especificada',
            'data' => $monuments,
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
