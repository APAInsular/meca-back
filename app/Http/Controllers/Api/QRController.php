<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\QRControllerStoreRequest;
use App\Models\QR;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QRController extends Controller
{
    public function index(Request $request): Response
    {
        $qRS = QR::all();

        return response()->noContent(200);
    }

    public function store(QRControllerStoreRequest $request): Response
    {
        $qR = QR::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, QR $qR): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, QR $qR): Response
    {
        $qR->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, QR $qR): Response
    {
        $qR->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
