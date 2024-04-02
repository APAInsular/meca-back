<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EventoControllerStoreRequest;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventoController extends Controller
{
    public function index(Request $request): Response
    {
        $eventos = Evento::all();

        return response()->noContent(200);
    }

    public function store(EventoControllerStoreRequest $request): Response
    {
        $evento = Evento::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Evento $evento): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Evento $evento): Response
    {
        $evento->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Evento $evento): Response
    {
        $evento->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
