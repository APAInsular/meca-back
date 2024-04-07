<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stop;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StopController extends Controller
{
    public function index(Request $request): Response
    {
        $stops = Stop::all();

        return response()->noContent(200);
    }

    public function store(Request $request): Response
    {
        $stop = Stop::create($request->all());

        return response()->noContent(201);
    }

    public function show(Request $request, Stop $stop): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Stop $stop): Response
    {
        $stop->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Stop $stop): Response
    {
        $stop->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
