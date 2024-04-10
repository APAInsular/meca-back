<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BlogEntryStoreRequest;
use App\Models\BlogEntry;
use Illuminate\Http\Request;

class BlogEntryController extends Controller
{
    public function index(Request $request)
    {
        $blogEntries = BlogEntry::all();

        return response()->noContent(200);
    }

    public function store(BlogEntryStoreRequest $request)
    {
        $blogEntry = BlogEntry::create($request->validated());

        return response()->noContent(201);
    }

    public function show(Request $request, BlogEntry $blogEntry)
    {
        return response()->noContent(200);
    }

    public function update(Request $request, BlogEntry $blogEntry)
    {
        $blogEntry->update([]);

        return response()->noContent(200);
    }

    public function destroy(Request $request, BlogEntry $blogEntry)
    {
        $blogEntry->delete();

        return response()->noContent();
    }

    public function error(Request $request)
    {
        return response()->noContent(400);
    }
}
