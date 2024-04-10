<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ImageStoreRequest;
use App\Models\Image;
use Illuminate\Http\Request;


class ImageController extends Controller
{
    public function index(Request $request)
    {
        $images = Image::all();

        return response()->noContent(200);
    }

    public function store(ImageStoreRequest $request)
    {
        $image = Image::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Image $image)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Image $image)
    {
        $image->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Image $image)
    {
        $image->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
