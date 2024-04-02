<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PatrocinadorControllerStoreRequest;
use App\Models\Patrocinador;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatrocinadorController extends Controller
{
    public function index(Request $request): Response
    {
        $patrocinadors = Patrocinador::all();

        return response()->noContent(200);
    }

    public function store(PatrocinadorControllerStoreRequest $request): Response
    {
        $patrocinador = Patrocinador::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Patrocinador $patrocinador): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Patrocinador $patrocinador): Response
    {
        $patrocinador->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Patrocinador $patrocinador): Response
    {
        $patrocinador->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
