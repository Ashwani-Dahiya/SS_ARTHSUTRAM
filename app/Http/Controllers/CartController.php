<?php

namespace App\Http\Controllers;

use App\Models\CartModel;
use App\Models\IPAddressModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class CartController extends Controller
{
    public function cart_page()
    {
        $user = Auth::user();
        $carts = CartModel::where('user_id', $user->id)->get();

        // Create an array to store product IDs in the cart
        $productIdsInCart = $carts->pluck('product_id')->toArray();

        // Create an array to store category IDs of products in the cart
        $categoryIds = ProductModel::whereIn('id', $productIdsInCart)->pluck('category_id')->toArray();

        // Fetch recommended products based on the categories of products in the cart
        $recommendedProducts = ProductModel::whereNotIn('id', $productIdsInCart)
            ->whereIn('category_id', $categoryIds)
            ->limit(10) // Limit to a reasonable number
            ->get();

        return view('cart', compact('carts', 'recommendedProducts'));
    }




    public function add_to_cart(Request $request)
    {
        // dd($request->all());
        $user = User::find(Auth::user()->id);
        $product_id = $request->product_id;

        // Check if the product is already in the cart
        $cart = $user->carts()->where('product_id', $product_id)->first();

        if ($cart) {
            // If the product is already in the cart, update the quantity
            $cart->increment('times'); // You can customize this based on your needs
            $times = $cart->times;
            $cart->size = $request->size;
        } else {
            // If the product is not in the cart, add a new item with times = 1
            $cart = new CartModel();
            $cart->user_id = $user->id;
            $cart->product_id = $product_id;
            $cart->times = 1; // Set times to 1
            $cart->size = $request->size;
            $cart->save();
            $times = 1;
        }

        $data = [
            'success' => true,
            'times' => $times,
            // any other data you want to include
        ];

        return redirect()->route('cart.page')->with('add-to-cart-success','success-cart');
    }

    public function buy_now(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $product_id = $request->product_id;

        // Check if the product is already in the cart
        $cart = $user->carts()->where('product_id', $product_id)->first();

        if ($cart) {
            // If the product is already in the cart, update the quantity
            $cart->increment('times'); // You can customize this based on your needs
            $times = $cart->times;
            $cart->size = $request->size;
        } else {
            // If the product is not in the cart, add a new item
            $cart = new CartModel();
            $cart->user_id = $user->id;
            $cart->product_id = $product_id;
            $cart->size = $request->size;
            $cart->save();
            $times = 1;
        }

        return redirect()->route('cart.page');
    }


    public function updateQuantity(Request $request)
    {
        $user_id = Auth::user()->id;
        $cart = CartModel::where('id', $request->cart_id)
            ->where('user_id', $user_id)
            ->orWhere('product_id', $request->product_id)
            ->first();
        $product = ProductModel::findOrFail($request->product_id);

        if ($cart) {
            $times = $cart->times + $request->increment;
            // Update the quantity based on the increment value
            $cart->update([
                'times' => $cart->times + $request->increment,
            ]);

            // Return a JSON response indicating success
            return response()->json([
                'success' => true,
                'message' => 'Cart quantity updated successfully',
                'times' => $times,
                'price' => $product->discounted_price,


            ]);
        } else {
            // If the cart item is not found, return a JSON response indicating failure
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found',
            ]);
        }
    }




    public function cart_count()
    {
        if (Auth::user()) {
            $cartCount = CartModel::where('user_id', Auth::user()->id)->count();
            return response()->json([
                'success' => true,
                'cartCount' => $cartCount,
            ]);
        } else {
            $ip = request()->ip();
            $IpID = IPAddressModel::where('ip_address', $ip)->first();
            $cartCount = CartModel::where('ip_id', $IpID->id)->get()->count();
            return response()->json([
                'success' => true,
                'cartCount' => $cartCount,

            ]);
        }
    }
    public function delete_cart_item($id)
    {
        try {
            CartModel::where('id', $id)->delete();
            return redirect()->back()->with('success-delete', 'Item deleted from cart successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while removing the item from the cart.');
        }
    }
    public function clear_cart_items()
    {
        try {
            CartModel::where('user_id', Auth::user()->id)->delete();
            return redirect()->back()->with('success-deleted', 'Cart cleared successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while clearing the cart.');
        }
    }
}
