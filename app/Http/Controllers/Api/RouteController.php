<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RouteControllerStoreRequest;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RouteController extends Controller
{
    public function index(Request $request): Response
    {
        $routes = Route::all();

        return response()->noContent(200);
    }

    public function store(RouteControllerStoreRequest $request): Response
    {
        $route = Route::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Route $route): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Route $route): Response
    {
        $route->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Route $route): Response
    {
        $route->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
