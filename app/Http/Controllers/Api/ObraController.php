<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ObraStoreRequest;
use App\Models\Obra;
use Illuminate\Http\Request;


class ObraController extends Controller
{
    public function index(Request $request)
    {
        $obras = Obra::all();

        return response()->noContent(200);
    }

    public function store(ObraStoreRequest $request)
    {
        $obra = Obra::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Obra $obra)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Obra $obra)
    {
        $obra->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Obra $obra)
    {
        $obra->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
