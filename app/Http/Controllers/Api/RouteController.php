<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RouteStoreRequest;
use App\Models\Route;
use Illuminate\Http\Request;


class RouteController extends Controller
{
    public function index(Request $request)
    {
        $routes = Route::all();

        return response()->noContent(200);
    }

    public function store(RouteStoreRequest $request)
    {
        $route = Route::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Route $route)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Route $route)
    {
        $route->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Route $route)
    {
        $route->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
