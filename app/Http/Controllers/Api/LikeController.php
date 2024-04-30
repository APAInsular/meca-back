<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the likes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $likes = Like::all();

        if ($likes->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se encontraron likes!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Likes encontrados!',
            'data' => $likes,
        ], 200);
    }

    /**
     * Store a newly created like in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'likable_type' => 'required|string',
            'likable_id' => 'required|integer',
        ]);

        $like = Like::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => '¡Like creado exitosamente!',
            'data' => $like,
        ], 201);
    }

    /**
     * Display the specified like.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Like $like)
    {
        if (is_null($like)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el like!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando detalles del like!',
            'data' => $like,
        ], 200);
    }

    /**
     * Remove the specified like from storage.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Like $like)
    {
        if (is_null($like)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado el like para eliminar!',
            ], 404);
        }

        $like->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Like eliminado!',
        ], 204);
    }

    /**
     * Handle an error with the controller methods.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => '¡Ha ocurrido un error con los métodos del controlador para likes!',
        ], 400);
    }
}
