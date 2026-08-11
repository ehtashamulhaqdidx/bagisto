<?php

namespace Webkul\Marketplace\Http\Controllers\Shop;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Webkul\Marketplace\Models\SellerProxy;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $customer = auth()->guard('customer')->user();

        if (! $customer) {
            return redirect()->route('shop.customer.session.index');
        }

        $seller = SellerProxy::modelClass()::where('customer_id', $customer->id)->first();

        if (! $seller || ! $seller->is_approved) {
            return redirect()->route('marketplace.seller.request')->with('warning', 'Your seller account is not approved yet.');
        }

        return view('marketplace::shop.dashboard', compact('seller'));
    }
}
