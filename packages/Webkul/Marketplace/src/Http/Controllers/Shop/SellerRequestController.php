<?php

namespace Webkul\Marketplace\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Webkul\Marketplace\Http\Requests\SellerRequest;
use Webkul\Marketplace\Models\SellerProxy;

class SellerRequestController extends Controller
{
    public function create()
    {
        return view('marketplace::shop.sellers.request');
    }

    public function store(SellerRequest $request)
    {
        $customer = auth()->guard('customer')->user();

        if (! $customer) {
            return redirect()->route('shop.customer.session.index');
        }

        $data = $request->validated();

        $data['customer_id'] = $customer->id;
        $data['is_approved'] = false;
        $data['status'] = false;

        SellerProxy::modelClass()::create($data);

        return redirect()->route('marketplace.seller.dashboard')
            ->with('success', trans('marketplace::messages.seller.create'));
    }
}
