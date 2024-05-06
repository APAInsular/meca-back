<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CommentStoreRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function howManyComments()
    {
        $commentsCount = DB::table('comments')
            ->select('commentable_type', 'commentable_id', DB::raw('count(*) as comments_count'))
            ->groupBy('commentable_type', 'commentable_id')
            ->get();

        foreach ($commentsCount as $comment) {
            echo $comment->commentable_type . ' ' . $comment->commentable_id . ' has ' . $comment->comments_count . ' comments' . PHP_EOL;
        }

    }

    public function index()
    {
        $comments = Comment::all();

        if ($comments->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No hay comentarios disponibles!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Comentarios encontrados!',
            'data' => $comments,
        ], 200);
    }

    public function store(CommentStoreRequest $request)
    {
        $validatedData = $request->validated();

        $comment = Comment::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => '¡Comentario creado exitosamente!',
            'data' => $comment,
        ], 201);
    }

    public function show(Comment $comment)
    {
        if (!$comment) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Comentario no encontrado!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando detalles del comentario!',
            'data' => $comment,
        ], 200);
    }

    public function update(Request $request, Comment $comment)
    {
        if (!$comment) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Comentario no encontrado para actualizar!',
            ], 404);
        }

        $validatedData = $request->validated();

        $comment->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => '¡Comentario actualizado exitosamente!',
            'data' => $comment,
        ], 200);
    }

    public function destroy(Comment $comment)
    {
        if (!$comment) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Comentario no encontrado para eliminar!',
            ], 404);
        }

        $comment->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Comentario eliminado exitosamente!',
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => '¡Ocurrió un error al procesar la solicitud!',
        ], 400);
    }
}

