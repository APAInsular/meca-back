<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StyleStoreRequest;
use App\Models\Style;
use Illuminate\Http\Request;


class StyleController extends Controller
{
    public function index(Request $request)
    {
        $styles = Style::all();

        return response()->noContent(200);
    }

    public function store(StyleStoreRequest $request)
    {
        $style = Style::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Style $style)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Style $style)
    {
        $style->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Style $style)
    {
        $style->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
