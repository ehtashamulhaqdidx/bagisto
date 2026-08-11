<?php

namespace Webkul\Marketplace\Http\Controllers\Seller;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Webkul\Sales\Models\Order;

class OrderController extends Controller
{
    /**
     * Lists orders that contain at least one item belonging to this seller.
     * The seller only ever sees their own line items, never another
     * seller's items within the same order.
     */
    public function index(): View
    {
        $seller = Auth::guard('seller')->user();

        $orders = Order::whereHas('items', function ($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        })->latest()->paginate(20);

        return view('marketplace::seller.orders.index', compact('orders'));
    }

    public function show(int $id): View
    {
        $seller = Auth::guard('seller')->user();

        $order = Order::whereHas('items', function ($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        })->findOrFail($id);

        // Only expose this seller's own items to the view, even though the
        // parent order may contain other sellers' products too.
        $items = $order->items->where('seller_id', $seller->id);

        return view('marketplace::seller.orders.show', compact('order', 'items'));
    }
}
