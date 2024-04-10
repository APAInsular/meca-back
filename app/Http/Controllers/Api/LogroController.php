<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LogroStoreRequest;
use App\Models\Logro;
use Illuminate\Http\Request;


class LogroController extends Controller
{
    public function index(Request $request)
    {
        $logros = Logro::all();

        return response()->noContent(200);
    }

    public function store(LogroStoreRequest $request)
    {
        $logro = Logro::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Logro $logro)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Logro $logro)
    {
        $logro->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Logro $logro)
    {
        $logro->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
