<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MonumentControllerStoreRequest;
use App\Models\Monument;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MonumentController extends Controller
{
    public function index(Request $request): Response
    {
        $monuments = Monument::all();

        return response()->noContent(200);
    }

    public function store(MonumentControllerStoreRequest $request): Response
    {
        $monument = Monument::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Monument $monument): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Monument $monument): Response
    {
        $monument->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Monument $monument): Response
    {
        $monument->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
