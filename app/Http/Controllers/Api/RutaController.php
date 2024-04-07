<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RutaControllerStoreRequest;
use App\Models\Ruta;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RutaController extends Controller
{
    public function index(Request $request): Response
    {
        $ruta = Rutum::all();

        return response()->noContent(200);
    }

    public function store(RutaControllerStoreRequest $request): Response
    {
        $ruta = Ruta::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Rutum $rutum): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Rutum $rutum): Response
    {
        $ruta->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Rutum $rutum): Response
    {
        $ruta->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
