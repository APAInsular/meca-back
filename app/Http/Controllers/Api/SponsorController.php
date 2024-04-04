<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SponsorControllerStoreRequest;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SponsorController extends Controller
{
    public function index(Request $request): Response
    {
        $sponsors = Sponsor::all();

        return response()->noContent(200);
    }

    public function store(SponsorControllerStoreRequest $request): Response
    {
        $sponsor = Sponsor::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Sponsor $sponsor): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Sponsor $sponsor): Response
    {
        $sponsor->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Sponsor $sponsor): Response
    {
        $sponsor->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
