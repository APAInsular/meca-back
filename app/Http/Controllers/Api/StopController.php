<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StopStoreRequest;
use App\Models\Stop;
use Illuminate\Http\Request;


class StopController extends Controller
{
    public function index(StopStoreRequest $request)
    {
        $stops = Stop::all();

        return response()->noContent(200);
    }

    public function store(StopStoreRequest $request)
    {
        $stop = Stop::create($request->all());

        return response()->noContent(201);
    }

    public function show(StopStoreRequest $request, Stop $stop)
    {
        return response()->noContent(200);
    }

    public function update(StopStoreRequest $request, Stop $stop)
    {
        $stop->update([]);

        return response()->noContent(200);
    }

    public function destroy(StopStoreRequest $request, Stop $stop)
    {
        $stop->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
