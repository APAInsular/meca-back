<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EventStoreRequest;
use App\Models\Event;
use Illuminate\Http\Request;


class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::all();

        return response()->noContent(200);
    }

    public function store(EventStoreRequest $request)
    {
        $event = Event::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Event $event)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Event $event)
    {
        $event->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Event $event)
    {
        $event->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
