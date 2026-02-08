<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserItemMaster;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = UserItemMaster::with('category')
            ->orderBy('item_id', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Items fetched successfully',
            'data' => $items,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cat_id' => 'required|integer|exists:res_category_master,category_id',
            'price' => 'required|integer|min:0',
        ]);

        $item = UserItemMaster::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Item created successfully',
            'data' => $item,
        ], 201);
    }

    public function show($id)
    {
        $item = UserItemMaster::with('category')->find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Item not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Item fetched successfully',
            'data' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = UserItemMaster::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Item not found',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cat_id' => 'required|integer|exists:res_category_master,category_id',
            'price' => 'required|integer|min:0',
        ]);

        $item->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Item updated successfully',
            'data' => $item,
        ]);
    }

    public function destroy($id)
    {
        $item = UserItemMaster::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Item not found',
            ], 404);
        }

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Item deleted successfully',
        ]);
    }
}
