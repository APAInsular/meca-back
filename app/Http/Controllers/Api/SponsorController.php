<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SponsorStoreRequest;
use App\Models\Sponsor;
use Illuminate\Http\Request;


class SponsorController extends Controller
{
    public function index(Request $request)
    {
        $sponsors = Sponsor::all();

        return response()->noContent(200);
    }

    public function store(SponsorStoreRequest $request)
    {
        $sponsor = Sponsor::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Sponsor $sponsor)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $sponsor->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Sponsor $sponsor)
    {
        $sponsor->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
