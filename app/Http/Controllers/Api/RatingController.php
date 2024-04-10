<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RatingStoreRequest;
use App\Models\Rating;
use Illuminate\Http\Request;


class RatingController extends Controller
{
    public function index(Request $request)
    {
        $ratings = Rating::all();

        return response()->noContent(200);
    }

    public function store(RatingStoreRequest $request)
    {
        $rating = Rating::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Rating $rating)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Rating $rating)
    {
        $rating->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Rating $rating)
    {
        $rating->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
