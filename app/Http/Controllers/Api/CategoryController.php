<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ResCategoryMaster;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = ResCategoryMaster::orderBy('category_id', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Categories fetched successfully',
            'data' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = ResCategoryMaster::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully',
            'data' => $category,
        ], 201);
    }

    public function show($id)
    {
        $category = ResCategoryMaster::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Category fetched successfully',
            'data' => $category,
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = ResCategoryMaster::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully',
            'data' => $category,
        ]);
    }

    public function destroy($id)
    {
        $category = ResCategoryMaster::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ], 404);
        }

        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully',
        ]);
    }
}
