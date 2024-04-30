<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EventStoreRequest;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        if ($events->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No se encontraron eventos.',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Eventos encontrados exitosamente.',
            'data' => $events,
        ], 200);
    }

    public function store(EventStoreRequest $request)
    {
        $validatedData = $request->validated();

        $event = Event::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Evento creado exitosamente.',
            'data' => $event,
        ], 201);
    }

    public function show(Event $event)
    {
        if (!$event) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Evento no encontrado.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detalles del evento mostrados exitosamente.',
            'data' => $event,
        ], 200);
    }

    public function update(EventStoreRequest $request, Event $event)
    {
        if (!$event) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Evento no encontrado para actualizar.',
            ], 404);
        }

        $validatedData = $request->validated();

        $event->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Evento actualizado exitosamente.',
            'data' => $event,
        ], 200);
    }

    public function destroy(Event $event)
    {
        if (!$event) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Evento no encontrado para eliminar.',
            ], 404);
        }

        $event->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Evento eliminado exitosamente.',
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Ocurrió un error al procesar la solicitud de eventos.',
        ], 400);
    }
}
