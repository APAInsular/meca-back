<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddressStoreRequest;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $addresses = Address::all();

        return response()->noContent(200);
    }

    public function store(AddressStoreRequest $request)
    {
        $address = Address::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, Address $address)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, Address $address)
    {
        $address->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, Address $address)
    {
        $address->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
