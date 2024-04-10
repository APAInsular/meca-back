<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EstiloStoreRequest;
use App\Models\Estilo;
use Illuminate\Http\Request;


class EstiloController extends Controller
{
    public function index(Request $request)
    {
        $estilos = Estilo::all();

        return response()->noContent(200);
    }

    public function store(EstiloStoreRequest $request)
    {
        $estilo = Estilo::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Estilo $estilo)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Estilo $estilo)
    {
        $estilo->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Estilo $estilo)
    {
        $estilo->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
