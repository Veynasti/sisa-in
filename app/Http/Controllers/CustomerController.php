<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['merchant', 'category'])
            ->where('status', 'available')
            ->whereHas('merchant', function ($query) {
                $query->where('verification_status', 'approved');
            })
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ILIKE', "%{$search}%")
                        ->orWhere('description', 'ILIKE', "%{$search}%");
                });
            })
            ->when($request->category, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('dashboard', compact(
            'products',
            'categories'
        ));
    }
}
