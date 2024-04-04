<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SubAchievementControllerStoreRequest;
use App\Models\SubAchievement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubAchievementController extends Controller
{
    public function index(Request $request): Response
    {
        $subAchievements = SubAchievement::all();

        return response()->noContent(200);
    }

    public function store(SubAchievementControllerStoreRequest $request): Response
    {
        $subAchievement = SubAchievement::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, SubAchievement $subAchievement): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, SubAchievement $subAchievement): Response
    {
        $subAchievement->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, SubAchievement $subAchievement): Response
    {
        $subAchievement->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
