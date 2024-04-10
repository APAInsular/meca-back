<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\QRStoreRequest;
use App\Models\QR;
use Illuminate\Http\Request;


class QRController extends Controller
{
    public function index(Request $request)
    {
        $qRS = QR::all();

        return response()->noContent(200);
    }

    public function store(QRStoreRequest $request)
    {
        $qR = QR::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, QR $qR)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, QR $qR)
    {
        $qR->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, QR $qR)
    {
        $qR->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
