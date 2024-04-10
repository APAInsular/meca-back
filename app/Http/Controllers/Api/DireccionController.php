<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DireccionControllerStoreRequest;
use App\Models\Direccion;
use Illuminate\Http\Request;


class DireccionController extends Controller
{
    public function index(Request $request)
    {
        $direccions = Direccion::all();

        return response()->noContent(200);
    }

    public function store(DireccionStoreRequest $request)
    {
        $direccion = Direccion::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Direccion $direccion)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Direccion $direccion)
    {
        $direccion->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Direccion $direccion)
    {
        $direccion->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
