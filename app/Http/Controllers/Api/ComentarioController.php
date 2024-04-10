<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ComentarioStoreRequest;
use App\Models\Comentario;
use Illuminate\Http\Request;


class ComentarioController extends Controller
{
    public function index(Request $request)
    {
        $comentarios = Comentario::all();

        return response()->noContent(200);
    }

    public function store(ComentarioStoreRequest $request)
    {
        $comentario = Comentario::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Comentario $comentario)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Comentario $comentario)
    {
        $comentario->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Comentario $comentario)
    {
        $comentario->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
