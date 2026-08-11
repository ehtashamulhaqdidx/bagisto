<?php

namespace Webkul\Marketplace\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Webkul\Marketplace\Models\SellerProxy;

class EnsureSellerIsApproved
{
    public function handle(Request $request, Closure $next)
    {
        $customer = auth()->guard('customer')->user();

        if (! $customer) {
            return redirect()->route('shop.customer.session.index');
        }

        $seller = SellerProxy::modelClass()::where('customer_id', $customer->id)->first();

        if (! $seller || ! $seller->is_approved) {
            return redirect()->route('marketplace.seller.request')->with('warning', 'Your seller account is not approved yet.');
        }

        return $next($request);
    }
}
