<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddressControllerStoreRequest;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    public function index(Request $request): Response
    {
        $addresses = Address::all();

        return response()->noContent(200);
    }

    public function store(AddressControllerStoreRequest $request): Response
    {
        $address = Address::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Address $address): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Address $address): Response
    {
        $address->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Address $address): Response
    {
        $address->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
