<?php

namespace Webkul\Marketplace\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Seller
{
    /**
     * Ensures the request is from an authenticated seller whose account is approved.
     * Pending/disapproved/suspended sellers get bounced to a status page instead of the dashboard.
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::guard('seller')->check()) {
            return redirect()->route('marketplace.seller.login');
        }

        $seller = Auth::guard('seller')->user();

        if ($seller->status !== 'approved' && ! $request->routeIs('marketplace.seller.status')) {
            return redirect()->route('marketplace.seller.status');
        }

        return $next($request);
    }
}
