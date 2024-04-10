<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PatrocinadorStoreRequest;
use App\Models\Patrocinador;
use Illuminate\Http\Request;


class PatrocinadorController extends Controller
{
    public function index(Request $request)
    {
        $patrocinadors = Patrocinador::all();

        return response()->noContent(200);
    }

    public function store(PatrocinadorStoreRequest $request)
    {
        $patrocinador = Patrocinador::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Patrocinador $patrocinador)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Patrocinador $patrocinador)
    {
        $patrocinador->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Patrocinador $patrocinador)
    {
        $patrocinador->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
