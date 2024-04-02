<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LogroControllerStoreRequest;
use App\Models\Logro;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogroController extends Controller
{
    public function index(Request $request): Response
    {
        $logros = Logro::all();

        return response()->noContent(200);
    }

    public function store(LogroControllerStoreRequest $request): Response
    {
        $logro = Logro::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Logro $logro): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Logro $logro): Response
    {
        $logro->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Logro $logro): Response
    {
        $logro->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
