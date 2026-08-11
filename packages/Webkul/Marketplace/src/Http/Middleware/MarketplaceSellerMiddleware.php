<?php

namespace Webkul\Marketplace\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Webkul\Marketplace\Models\SellerProxy;

class MarketplaceSellerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $customer = auth()->guard('customer')->user();

        if (! $customer) {
            return redirect()->route('shop.customer.session.index');
        }

        $seller = SellerProxy::modelClass()::where('customer_id', $customer->id)->first();

        if (! $seller) {
            return redirect()->route('marketplace.seller.request');
        }

        return $next($request);
    }
}
