<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EventControllerStoreRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    public function index(Request $request): Response
    {
        $events = Event::all();

        return response()->noContent(200);
    }

    public function store(EventControllerStoreRequest $request): Response
    {
        $event = Event::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Event $event): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Event $event): Response
    {
        $event->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Event $event): Response
    {
        $event->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
