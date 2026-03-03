<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookAccess;
use App\Models\Category;
use App\Models\User;
use App\Models\Wishlist;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function indexAdmin()
    {
        $stats = [
            'total_books'      => Book::count(),
            'total_users'      => User::where('role', 'member')->count(),
            'total_categories' => Category::count(),
            'total_read_books' => BookAccess::where('status', 'active')->count(),
            'total_access'     => BookAccess::count(), // Total akses baca yang diberikan
        ];

        // Ambil 5 riwayat akses baca terbaru untuk tabel dashboard
        $loans = BookAccess::with(['user', 'book'])->latest()->limit(5)->get();

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'loans' => $loans,
        ]);
    }

    public function indexMember()
    {
        $user = Auth::user();

        $stats = [
            'my_borrowed' => BookAccess::where('user_id', $user->id)->where('status', 'active')->count(),
            'my_wishlist' => Wishlist::where('user_id', $user->id)->count(),
        ];

        // Ambil riwayat baca terakhir user
        $booksRead = BookAccess::where('user_id', $user->id)
            ->with('book')
            ->latest()
            ->limit(5)
            ->get();

        return Inertia::render('Dashboard', [
            'stats'        => $stats,
            'booksRead'    => $booksRead,
        ]);
    }
}