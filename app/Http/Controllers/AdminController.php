<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::where('role', 'pembeli')->count();
        $totalProducts = Product::count();
        $activeRentals = Rental::where('status', 'active')->count();
        $totalRevenue = Rental::where('payment_status', 'paid')
            ->join('products', 'rentals.product_id', '=', 'products.id')
            ->sum('products.rental_price');

        $recentRentals = Rental::with('user', 'product')
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::where('role', 'pembeli')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts',
            'activeRentals',
            'totalRevenue',
            'recentRentals',
            'recentUsers'
        ));
    }
}
