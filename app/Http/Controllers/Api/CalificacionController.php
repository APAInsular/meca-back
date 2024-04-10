<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CalificacionControllerStoreRequest;
use App\Models\Calificacion;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    public function index(Request $request)
    {
        $calificacions = Calificacion::all();

        return response()->noContent(200);
    }

    public function store(CalificacionControllerStoreRequest $request)
    {
        $calificacion = Calificacion::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Calificacion $calificacion)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Calificacion $calificacion)
    {
        $calificacion->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Calificacion $calificacion)
    {
        $calificacion->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
