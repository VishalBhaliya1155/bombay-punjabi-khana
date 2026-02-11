<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserCartMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $cart = UserCartMaster::with('item')
            ->where('user_id', $user->userid)
            ->orderBy('cart_id', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Cart fetched successfully',
            'data' => $cart,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'item_id' => 'required|integer|exists:res_item_master,item_id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $quantity = $validated['quantity'] ?? 1;

        $cart = UserCartMaster::where('user_id', $user->userid)
            ->where('item_id', $validated['item_id'])
            ->first();

        if ($cart) {
            $cart->quantity += $quantity;
            $cart->save();
        } else {
            $cart = UserCartMaster::create([
                'user_id' => $user->userid,
                'item_id' => $validated['item_id'],
                'quantity' => $quantity,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Cart updated successfully',
            'data' => $cart,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $cart = UserCartMaster::where('user_id', $user->userid)
            ->where('cart_id', $id)
            ->first();

        if (!$cart) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found',
            ], 404);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->quantity = $validated['quantity'];
        $cart->save();

        return response()->json([
            'status' => true,
            'message' => 'Cart item updated successfully',
            'data' => $cart,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $user = Auth::user();

        $cart = UserCartMaster::where('user_id', $user->userid)
            ->where('cart_id', $id)
            ->first();

        if (!$cart) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found',
            ], 404);
        }

        $cart->delete();

        return response()->json([
            'status' => true,
            'message' => 'Cart item deleted successfully',
        ]);
    }
}
