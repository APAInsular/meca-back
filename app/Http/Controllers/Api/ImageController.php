<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ImageControllerStoreRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function index(Request $request): Response
    {
        $images = Image::all();

        return response()->noContent(200);
    }

    public function store(ImageControllerStoreRequest $request): Response
    {
        $image = Image::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Image $image): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Image $image): Response
    {
        $image->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Image $image): Response
    {
        $image->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
