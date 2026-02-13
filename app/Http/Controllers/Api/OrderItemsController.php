<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ResOrderItemsMaster;
use Illuminate\Http\Request;

class OrderItemsController extends Controller
{
    public function index()
    {
        $items = ResOrderItemsMaster::with(['order', 'item'])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Order items fetched successfully',
            'data' => $items,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|integer|exists:order_master,order_id',
            'item_id' => 'required|integer|exists:res_item_master,item_id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
        ]);

        $item = ResOrderItemsMaster::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Order item created successfully',
            'data' => $item,
        ], 201);
    }

    public function show($id)
    {
        $item = ResOrderItemsMaster::with(['order', 'item'])->find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Order item not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Order item fetched successfully',
            'data' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = ResOrderItemsMaster::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Order item not found',
            ], 404);
        }

        $validated = $request->validate([
            'order_id' => 'required|integer|exists:order_master,order_id',
            'item_id' => 'required|integer|exists:res_item_master,item_id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
        ]);

        $item->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Order item updated successfully',
            'data' => $item,
        ]);
    }

    public function destroy($id)
    {
        $item = ResOrderItemsMaster::find($id);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'Order item not found',
            ], 404);
        }

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Order item deleted successfully',
        ]);
    }
}
