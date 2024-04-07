<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CommentControllerStoreRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function index(Request $request): Response
    {
        $comments = Comment::all();

        return response()->noContent(200);
    }

    public function store(CommentControllerStoreRequest $request): Response
    {
        $comment = Comment::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Comment $comment): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Comment $comment): Response
    {
        $comment->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Comment $comment): Response
    {
        $comment->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
