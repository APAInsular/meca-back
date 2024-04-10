<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AchievementStoreRequest;
use App\Models\Achievement;
use Illuminate\Http\Request;


class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $achievements = Achievement::all();

        return response()->noContent(200);
    }

    public function store(AchievementStoreRequest $request)
    {
        $achievement = Achievement::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Achievement $achievement)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Achievement $achievement)
    {
        $achievement->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Achievement $achievement)
    {
        $achievement->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
