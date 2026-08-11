<?php

namespace Webkul\Marketplace\Http\Controllers\Seller;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Webkul\Marketplace\Models\Commission;

class DashboardController extends Controller
{
    public function index(): View
    {
        $seller = Auth::guard('seller')->user();

        $stats = [
            'total_products'    => $seller->products()->count(),
            'total_orders'      => Commission::where('seller_id', $seller->id)->distinct('order_id')->count('order_id'),
            'total_sales'       => Commission::where('seller_id', $seller->id)->sum('item_total'),
            'available_balance' => $seller->availableBalance(),
        ];

        return view('marketplace::seller.dashboard.index', compact('seller', 'stats'));
    }
}
