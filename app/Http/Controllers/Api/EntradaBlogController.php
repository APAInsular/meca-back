<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EntradaBlogControllerStoreRequest;
use App\Models\EntradaBlog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EntradaBlogController extends Controller
{
    public function index(Request $request): Response
    {
        $entradaBlogs = EntradaBlog::all();

        return response()->noContent(200);
    }

    public function store(EntradaBlogControllerStoreRequest $request): Response
    {
        $entradaBlog = EntradaBlog::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, EntradaBlog $entradaBlog): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, EntradaBlog $entradaBlog): Response
    {
        $entradaBlog->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, EntradaBlog $entradaBlog): Response
    {
        $entradaBlog->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
