<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parada;
use Illuminate\Http\Request;


class ParadaController extends Controller
{
    public function index(Request $request)
    {
        $paradas = Parada::all();

        return response()->noContent(200);
    }

    public function store(Request $request)
    {
        $parada = Parada::create($request->all());

        return response()->noContent(201);
    }

    public function show(Request $request, Parada $parada)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Parada $parada)
    {
        $parada->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Parada $parada)
    {
        $parada->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
