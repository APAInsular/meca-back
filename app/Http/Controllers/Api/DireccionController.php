<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DireccionControllerStoreRequest;
use App\Models\Direccion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DireccionController extends Controller
{
    public function index(Request $request): Response
    {
        $direccions = Direccion::all();

        return response()->noContent(200);
    }

    public function store(DireccionControllerStoreRequest $request): Response
    {
        $direccion = Direccion::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Direccion $direccion): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Direccion $direccion): Response
    {
        $direccion->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Direccion $direccion): Response
    {
        $direccion->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
