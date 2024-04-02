<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ComentarioControllerStoreRequest;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComentarioController extends Controller
{
    public function index(Request $request): Response
    {
        $comentarios = Comentario::all();

        return response()->noContent(200);
    }

    public function store(ComentarioControllerStoreRequest $request): Response
    {
        $comentario = Comentario::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Comentario $comentario): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Comentario $comentario): Response
    {
        $comentario->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Comentario $comentario): Response
    {
        $comentario->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
