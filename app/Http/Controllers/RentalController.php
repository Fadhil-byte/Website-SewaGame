<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Rental::with('product', 'user');

        if ($user->role === 'admin') {
            $rentals = $query->latest()->paginate(15);
            return view('rentals.admin_index', compact('rentals'));
        }

        $rentals = $query->where('user_id', $user->id)->latest()->paginate(10);
        $now = now()->toDateString();
        foreach ($rentals as $rental) {
            $rental->is_expired = $rental->end_date < $now || $rental->status === 'expired';
        }

        return view('rentals.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        $rental->load('product', 'user');

        if (Auth::user()->role === 'admin') {
            $rental->is_expired = $rental->end_date < now()->toDateString() || $rental->status === 'expired';
            return view('rentals.admin_show', compact('rental'));
        }

        if (Auth::id() !== $rental->user_id) {
            abort(403);
        }

        $rental->is_expired = $rental->end_date < now()->toDateString() || $rental->status === 'expired';
        return view('rentals.show', compact('rental'));
    }

    public function updateStatus(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,expired',
        ]);

        if ($validated['status'] === 'expired') {
            $rental->update([
                'status' => 'expired',
                'payment_status' => 'unpaid',
                'github_link' => null,
                'itchio_link' => null,
            ]);
        } else {
            $rental->update([
                'status' => 'active',
                'payment_status' => 'paid',
            ]);
        }

        return back()->with('success', 'Status peminjaman diperbarui.');
    }

    public function sendLinksForm(Rental $rental)
    {
        $rental->load('product', 'user');

        return view('rentals.send_links', compact('rental'));
    }

    public function sendLinks(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'github_link' => 'nullable|string',
            'itchio_link' => 'nullable|string',
        ]);

        $rental->update([
            'status' => 'active',
            'payment_status' => 'paid',
            'github_link' => $this->sanitizeLink($validated['github_link'] ?? $rental->product->github_link),
            'itchio_link' => $this->sanitizeLink($validated['itchio_link'] ?? $rental->product->itchio_link),
        ]);

        return redirect()->route('admin.rentals.index')->with('success', 'Link berhasil dikirim. Peminjaman aktif.');
    }

    public function reject(Rental $rental)
    {
        $rental->update([
            'status' => 'expired',
            'payment_status' => 'unpaid',
            'github_link' => null,
            'itchio_link' => null,
        ]);

        return redirect()->route('admin.rentals.index')->with('success', 'Peminjaman ditolak. Status pembayaran dikembalikan.');
    }

    public function expire(Rental $rental)
    {
        $updateData = [
            'status' => 'expired',
            'github_link' => null,
            'itchio_link' => null,
        ];

        if ($rental->payment_status !== 'paid') {
            $updateData['payment_status'] = 'unpaid';
        }

        $rental->update($updateData);

        return redirect()->route('admin.rentals.index')->with('success', 'Peminjaman expired.');
    }

    private function sanitizeLink($value): ?string
    {
        $value = trim((string) $value);

        if ($value === '' || $value === '0' || strtolower($value) === 'null') {
            return null;
        }

        return $value;
    }
}
