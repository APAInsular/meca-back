<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RatingControllerStoreRequest;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RatingController extends Controller
{
    public function index(Request $request): Response
    {
        $ratings = Rating::all();

        return response()->noContent(200);
    }

    public function store(RatingControllerStoreRequest $request): Response
    {
        $rating = Rating::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Rating $rating): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Rating $rating): Response
    {
        $rating->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Rating $rating): Response
    {
        $rating->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
