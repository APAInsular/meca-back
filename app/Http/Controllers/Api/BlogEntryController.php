<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BlogEntryControllerStoreRequest;
use App\Models\BlogEntry;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlogEntryController extends Controller
{
    public function index(Request $request): Response
    {
        $blogEntries = BlogEntry::all();

        return response()->noContent(200);
    }

    public function store(BlogEntryControllerStoreRequest $request): Response
    {
        $blogEntry = BlogEntry::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, BlogEntry $blogEntry): Response
    {
        return response()->noContent(200);
    }

    public function update(Request $request, BlogEntry $blogEntry): Response
    {
        $blogEntry->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, BlogEntry $blogEntry): Response
    {
        $blogEntry->delete();

        return response()->noContent();
    }

    public function error(Request $request): Response
    {
        return response()->noContent(400);
    }
}
