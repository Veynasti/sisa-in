<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Merchant;
use App\Models\Product;
use App\Models\Order;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistik merchant
        $totalMerchants = Merchant::count();
        $pendingCount = Merchant::where('verification_status', 'pending')->count();
        $approvedCount = Merchant::where('verification_status', 'approved')->count();
        $rejectedCount = Merchant::where('verification_status', 'rejected')->count();

        // Statistik lainnya
        $totalCustomers = User::where('role', 'customer')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();

        // Lima merchant terbaru
        $recentMerchants = Merchant::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMerchants',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'totalCustomers',
            'totalProducts',
            'totalOrders',
            'recentMerchants'
        ));
    }
}
