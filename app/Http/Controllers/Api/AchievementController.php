<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AchievementControllerStoreRequest;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AchievementController extends Controller
{
    public function index(Request $request): Response
    {
        $achievements = Achievement::all();

        return response()->noContent(200);
    }

    public function store(AchievementControllerStoreRequest $request): Response
    {
        $achievement = Achievement::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Achievement $achievement): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Achievement $achievement): Response
    {
        $achievement->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Achievement $achievement): Response
    {
        $achievement->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
