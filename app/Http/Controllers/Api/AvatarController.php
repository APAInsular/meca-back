<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvatarRequest;
use App\Models\Avatar;

class AvatarController extends Controller
{
    public function index()
    {
        $avatars = Avatar::all();

        if ($avatars->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No avatars found!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Avatars found!',
            'data' => $avatars,
        ], 200);
    }

    public function store(AvatarRequest $request)
    {
        $validated = $request->validated();

        $avatar = Avatar::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Avatar created successfully!',
            'data' => $avatar,
        ], 201);
    }

    public function show(Avatar $avatar)
    {
        if (is_null($avatar)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Avatar not found!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Showing avatar details!',
            'data' => $avatar,
        ], 200);
    }

    public function update(AvatarRequest $request, Avatar $avatar)
    {
        if (is_null($avatar)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Avatar not found for update!',
            ], 404);
        }

        $validated = $request->validated();

        $avatar->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Avatar updated!',
            'data' => $avatar,
        ], 200);
    }

    public function destroy(Avatar $avatar)
    {
        if (is_null($avatar)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Avatar not found for deletion!',
            ], 404);
        }

        $avatar->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Avatar deleted!',
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred with the controller methods for avatars!',
        ], 400);
    }
}
