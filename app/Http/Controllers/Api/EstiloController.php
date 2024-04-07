<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EstiloControllerStoreRequest;
use App\Models\Estilo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EstiloController extends Controller
{
    public function index(Request $request): Response
    {
        $estilos = Estilo::all();

        return response()->noContent(200);
    }

    public function store(EstiloControllerStoreRequest $request): Response
    {
        $estilo = Estilo::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Estilo $estilo): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Estilo $estilo): Response
    {
        $estilo->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Estilo $estilo): Response
    {
        $estilo->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
