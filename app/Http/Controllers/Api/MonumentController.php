<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MonumentStoreRequest;
use App\Models\Monument;
use Illuminate\Http\Request;


class MonumentController extends Controller
{
    public function index(Request $request)
    {
        $monuments = Monument::all();

        return response()->noContent(200);
    }

    public function store(MonumentStoreRequest $request)
    {
        $monument = Monument::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Monument $monument)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Monument $monument)
    {
        $monument->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Monument $monument)
    {
        $monument->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
