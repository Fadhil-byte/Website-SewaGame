<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Rental;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = auth()->user()->carts()->with('product')->latest()->get();

        if ($carts->isEmpty()) {
            return redirect()->route('pembeli.carts.index')->with('info', 'Keranjang Anda kosong. Tambahkan produk terlebih dahulu.');
        }

        return view('checkout.index', compact('carts'));
    }

    public function process(Request $request)
    {
        $user = auth()->user();
        $cartIds = $request->input('cart_ids', []);

        if (empty($cartIds)) {
            return redirect()->route('pembeli.carts.index')->with('info', 'Keranjang kosong.');
        }

        $carts = Cart::whereIn('id', $cartIds)
            ->where('user_id', $user->id)
            ->with('product')
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('pembeli.carts.index')->with('info', 'Keranjang kosong.');
        }

        $today = now()->toDateString();
        $endDate = now()->addDays(7)->toDateString();

        foreach ($carts as $cart) {
            $product = $cart->product;

            Rental::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'start_date' => $today,
                'end_date' => $endDate,
                'status' => 'pending',
                'payment_status' => 'paid',
                'github_link' => $product->github_link,
                'itchio_link' => $product->itchio_link,
            ]);

            $cart->delete();
        }

        return redirect()->route('pembeli.rentals.index')->with('success', 'Peminjaman berhasil. Sewa aktif 7 hari.');
    }
}
