<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ObraControllerStoreRequest;
use App\Models\Obra;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ObraController extends Controller
{
    public function index(Request $request): Response
    {
        $obras = Obra::all();

        return response()->noContent(200);
    }

    public function store(ObraControllerStoreRequest $request): Response
    {
        $obra = Obra::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Obra $obra): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Obra $obra): Response
    {
        $obra->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Obra $obra): Response
    {
        $obra->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
