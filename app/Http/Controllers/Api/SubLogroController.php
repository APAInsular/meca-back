<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SubLogroControllerStoreRequest;
use App\Models\SubLogro;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubLogroController extends Controller
{
    public function index(Request $request): Response
    {
        $subLogros = SubLogro::all();

        return response()->noContent(200);
    }

    public function store(SubLogroControllerStoreRequest $request): Response
    {
        $subLogro = SubLogro::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, SubLogro $subLogro): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, SubLogro $subLogro): Response
    {
        $subLogro->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, SubLogro $subLogro): Response
    {
        $subLogro->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
