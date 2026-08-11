<?php

namespace Webkul\Marketplace\Http\Controllers\Admin;

use Webkul\Marketplace\Http\Requests\SellerRequest;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Marketplace\Models\SellerProxy;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = SellerProxy::modelClass()::all();

        return view('marketplace::admin.sellers.index', compact('sellers'));
    }

    public function create()
    {
        return view('marketplace::admin.sellers.create');
    }

    public function store(SellerRequest $request)
    {
        SellerProxy::modelClass()::create($request->validated());

        return redirect()->route('admin.marketplace.sellers.index');
    }

    public function edit($id)
    {
        $seller = SellerProxy::modelClass()::findOrFail($id);

        return view('marketplace::admin.sellers.edit', compact('seller'));
    }

    public function update(SellerRequest $request, $id)
    {
        $seller = SellerProxy::modelClass()::findOrFail($id);
        $seller->update($request->validated());

        return redirect()->route('admin.marketplace.sellers.index');
    }

    public function approve($id)
    {
        $seller = SellerProxy::modelClass()::findOrFail($id);

        $seller->update([
            'is_approved' => true,
            'status' => true,
        ]);

        return redirect()->back();
    }
}
