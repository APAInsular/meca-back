<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EventoStoreRequest;
use App\Models\Evento;
use Illuminate\Http\Request;


class EventoController extends Controller
{
    public function index(Request $request)
    {
        $eventos = Evento::all();

        return response()->noContent(200);
    }

    public function store(EventoStoreRequest $request)
    {
        $evento = Evento::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Evento $evento)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Evento $evento)
    {
        $evento->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Evento $evento)
    {
        $evento->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
