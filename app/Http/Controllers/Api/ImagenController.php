<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ImagenControllerStoreRequest;
use App\Models\Imagen;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImagenController extends Controller
{
    public function index(Request $request): Response
    {
        $imagens = Imagen::all();

        return response()->noContent(200);
    }

    public function store(ImagenControllerStoreRequest $request): Response
    {
        $imagen = Imagen::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Imagen $imagen): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Imagen $imagen): Response
    {
        $imagen->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Imagen $imagen): Response
    {
        $imagen->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
