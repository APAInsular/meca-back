<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StyleControllerStoreRequest;
use App\Models\Style;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StyleController extends Controller
{
    public function index(Request $request): Response
    {
        $styles = Style::all();

        return response()->noContent(200);
    }

    public function store(StyleControllerStoreRequest $request): Response
    {
        $style = Style::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Style $style): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Style $style): Response
    {
        $style->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Style $style): Response
    {
        $style->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
