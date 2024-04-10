<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EntradaBlogStoreRequest;
use App\Models\EntradaBlog;
use Illuminate\Http\Request;


class EntradaBlogController extends Controller
{
    public function index(Request $request)
    {
        $entradaBlogs = EntradaBlog::all();

        return response()->noContent(200);
    }

    public function store(EntradaBlogStoreRequest $request)
    {
        $entradaBlog = EntradaBlog::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, EntradaBlog $entradaBlog)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, EntradaBlog $entradaBlog)
    {
        $entradaBlog->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, EntradaBlog $entradaBlog)
    {
        $entradaBlog->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
