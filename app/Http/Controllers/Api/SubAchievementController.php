<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SubAchievementStoreRequest;
use App\Models\SubAchievement;
use Illuminate\Http\Request;


class SubAchievementController extends Controller
{
    public function index(Request $request)
    {
        $subAchievements = SubAchievement::all();

        return response()->noContent(200);
    }

    public function store(SubAchievementStoreRequest $request)
    {
        $subAchievement = SubAchievement::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, SubAchievement $subAchievement)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, SubAchievement $subAchievement)
    {
        $subAchievement->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, SubAchievement $subAchievement)
    {
        $subAchievement->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
