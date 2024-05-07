<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EventStoreRequest;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function countTheEvents()
    {
        $currentTime = now();

        $numberOfUpcomingEvents = DB::table('event_route')
            ->join('routes', 'event_route.route_id', '=', 'routes.id')
            ->join('route_user', 'routes.id', '=', 'route_user.route_id')
            ->join('event_user', 'event_route.event_id', '=', 'event_user.event_id')
            ->where('route_user.created_at', '>', $currentTime)
            ->count();

        echo "Number of upcoming events: " . $numberOfUpcomingEvents;
    }

    public function findNearestEvents()
    {
        $currentTime = now();

        $upcomingEvents = DB::table('event_route')
            ->join('routes', 'event_route.route_id', '=', 'routes.id')
            ->join('route_user', 'routes.id', '=', 'route_user.route_id')
            ->join('event_user', 'event_route.event_id', '=', 'event_user.event_id')
            ->join('users', 'event_user.user_id', '=', 'users.id')
            ->select('routes.name as route_name', 'routes.city', 'routes.distance')
            ->where('route_user.created_at', '>', $currentTime)
            ->orderBy('routes.distance')
            ->get();

        echo "Upcoming events sorted by distance:\n";
        foreach ($upcomingEvents as $event) {
            echo "Route: " . $event->route_name . "\n";
            echo "City: " . $event->city . "\n";
            echo "Distance: " . $event->distance . " km\n\n";
        }
    }

    public function getInfoAboutUpcomingEvents()
    {
        $currentTime = now();

        $upcomingEvents = DB::table('event_route')
            ->join('routes', 'event_route.route_id', '=', 'routes.id')
            ->join('route_user', 'routes.id', '=', 'route_user.route_id')
            ->join('event_user', 'event_route.event_id', '=', 'event_user.event_id')
            ->join('users', 'event_user.user_id', '=', 'users.id')
            ->select('routes.name as route_name', 'routes.city', 'routes.distance', 'routes.time', 'users.name as user_name', 'users.email', 'route_user.created_at')
            ->where('route_user.created_at', '>', $currentTime)
            ->orderBy('route_user.created_at')
            ->get();

        foreach ($upcomingEvents as $event) {
            echo "Upcoming event: \n";
            echo "Route: " . $event->route_name . "\n";
            echo "City: " . $event->city . "\n";
            echo "Distance: " . $event->distance . " km\n";
            echo "Estimated time: " . $event->time . "\n";
            echo "User: " . $event->user_name . "\n";
            echo "User email: " . $event->email . "\n";
            echo "Created at: " . $event->created_at . "\n\n";
        }
    }

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
