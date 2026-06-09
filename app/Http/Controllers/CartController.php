<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = auth()->user()->carts()->with('product')->latest()->get();

        return view('carts.index', compact('carts'));
    }

    public function store(Request $request, Product $product)
    {
        $exists = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            return redirect()->route('pembeli.products.index')->with('info', 'Produk sudah ada di keranjang.');
        }

        Cart::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        return redirect()->route('pembeli.carts.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->route('pembeli.carts.index')->with('success', 'Produk dihapus dari keranjang.');
    }
}
