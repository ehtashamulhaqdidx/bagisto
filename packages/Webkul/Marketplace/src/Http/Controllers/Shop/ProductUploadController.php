<?php

namespace Webkul\Marketplace\Http\Controllers\Shop;

use Webkul\Marketplace\Http\Requests\MarketplaceProductRequest;
use Illuminate\Routing\Controller;
use Webkul\Marketplace\Models\SellerProxy;
use Webkul\Marketplace\Models\ProductSeller;

class ProductUploadController extends Controller
{
    public function create()
    {
        return view('marketplace::shop.products.create');
    }

    public function store(MarketplaceProductRequest $request)
    {
        ProductSeller::create($request->validated());

        return redirect()->route('marketplace.seller.dashboard');
    }
}
