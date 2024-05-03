<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function getCategoryPostCount()
    {
        $categories = DB::table('categories')
            ->join('blog_entry_category', 'categories.id', '=', 'blog_entry_category.category_id')
            ->select('categories.name as category_name', DB::raw('COUNT(blog_entry_category.blog_entry_id) as post_count'))
            ->groupBy('categories.name')
            ->get();

        foreach ($categories as $category) {
            echo "[$category->category_name] - has $category->post_count post \n";
        }
    }

    public function index()
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡No se encontraron categorías!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Categorías encontradas!',
            'data' => $categories,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 400);
        }

        $category = Category::create([
            'name' => $request->input('name'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => '¡Categoría creada exitosamente!',
            'data' => $category,
        ], 201);
    }

    public function show(Category $category)
    {
        if (!$category) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Categoría no encontrada!',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => '¡Mostrando datos de la categoría!',
            'data' => $category,
        ], 200);
    }

    public function update(Request $request, Category $category)
    {
        if (!$category) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Categoría no encontrada!',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 400);
        }

        $category->update([
            'name' => $request->input('name'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => '¡Categoría actualizada!',
            'data' => $category,
        ], 200);
    }

    public function destroy(Category $category)
    {
        if (!$category) {
            return response()->json([
                'status' => 'failed',
                'message' => '¡Categoría no encontrada!',
            ], 404);
        }

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => '¡Categoría eliminada!',
        ], 204);
    }

    public function error()
    {
        return response()->json([
            'status' => 'error',
            'message' => '¡Ha ocurrido un error con los métodos del controlador para categorías!',
        ], 400);
    }
}
