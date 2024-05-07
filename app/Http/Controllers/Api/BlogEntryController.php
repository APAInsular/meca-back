<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BlogEntryStoreRequest;
use App\Models\BlogEntry;
use Illuminate\Support\Facades\DB;

class BlogEntryController extends Controller
{
    public function getStatisticsFromPost()
    {
        $results = DB::select("
        SELECT
            blog_entries.id AS post_id,
            COUNT(DISTINCT post_likes.id) AS post_likes_count,
            COUNT(DISTINCT comments.id) AS comments_count,
            SUM(CASE WHEN comment_likes.likable_type = 'comment' THEN 1 ELSE 0 END) AS comment_likes_count
        FROM
            blog_entries
        LEFT JOIN
            comments ON blog_entries.id = comments.commentable_id AND comments.commentable_type = 'post'
        LEFT JOIN
            likes AS post_likes ON blog_entries.id = post_likes.likable_id AND post_likes.likable_type = 'post'
        LEFT JOIN
            likes AS comment_likes ON comments.id = comment_likes.likable_id AND comment_likes.likable_type = 'comment'
        GROUP BY
            blog_entries.id;
        ");
        

        foreach ($results as $result) {
            $post_id = $result->post_id;
            $post_likes_count = $result->post_likes_count;
            $comments_count = $result->comments_count;
            $comment_likes_count = $result->comment_likes_count;

            echo "Post $post_id has $post_likes_count likes and $comments_count comments with $comment_likes_count likes on comments\n";
        }
    }

    public function index()
    {
        $blogEntries = BlogEntry::all();

        if ($blogEntries->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se Encontraron Entradas de Blog!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Entradas de Blog Encontradas!',
            'data' => $blogEntries,
        ], 200);
    }

    public function store(BlogEntryStoreRequest $request)
    {
        $blogEntry = BlogEntry::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => '¡Entrada de Blog Creada Exitosamente!',
            'data' => $blogEntry,
        ], 201);
    }

    public function show(BlogEntry $blogEntry)
    {
        if (is_null($blogEntry)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la Entrada de Blog!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '!Mostrando Datos de la Entrada de Blog!',
            'data' => $blogEntry,
        ], 200);
    }

    public function update(BlogEntry $blogEntry)
    {
        if (is_null($blogEntry)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la Entrada de Blog para Actualizar!',
            ], 404);
        }

        $blogEntry->update([]);

        return response()->json([
            'status' => 'success',
            'message' => '¡Entrada de Blog Actualizada!',
            'data' => $blogEntry,
        ], 200);
    }

    public function destroy(BlogEntry $blogEntry)
    {
        if (is_null($blogEntry)) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se ha encontrado la Entrada de Blog para Eliminar!',
            ], 404);
        }

        $blogEntry->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Entrada de Blog Eliminada!',
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => '¡Ha Ocurrido un Error con los Métodos del Controlador para Entradas de Blog!',
        ], 400);
    }
}
