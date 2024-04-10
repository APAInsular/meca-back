<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SubLogroStoreRequest;
use App\Models\SubLogro;
use Illuminate\Http\Request;


class SubLogroController extends Controller
{
    public function index(Request $request)
    {
        $subLogros = SubLogro::all();

        return response()->noContent(200);
    }

    public function store(SubLogroStoreRequest $request)
    {
        $subLogro = SubLogro::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, SubLogro $subLogro)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, SubLogro $subLogro)
    {
        $subLogro->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, SubLogro $subLogro)
    {
        $subLogro->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
