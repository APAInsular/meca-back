<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ImagenStoreRequest;
use App\Models\Imagen;
use Illuminate\Http\Request;


class ImagenController extends Controller
{
    public function index(Request $request)
    {
        $imagens = Imagen::all();

        return response()->noContent(200);
    }

    public function store(ImagenStoreRequest $request)
    {
        $imagen = Imagen::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Imagen $imagen)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Imagen $imagen)
    {
        $imagen->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Imagen $imagen)
    {
        $imagen->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
