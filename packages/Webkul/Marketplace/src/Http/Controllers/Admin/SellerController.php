<?php

namespace Webkul\Marketplace\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Webkul\Marketplace\Models\Seller;
use Webkul\Marketplace\Repositories\SellerRepository;

class SellerController extends Controller
{
    public function __construct(protected SellerRepository $sellerRepository)
    {
    }

    public function index(Request $request): View
    {
        $sellers = $this->sellerRepository->paginateForAdmin($request->get('status'));

        return view('marketplace::admin.sellers.index', compact('sellers'));
    }

    public function edit(int $id): View
    {
        $seller = Seller::findOrFail($id);

        return view('marketplace::admin.sellers.edit', compact('seller'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $seller = Seller::findOrFail($id);

        $data = $request->validate([
            'status'          => ['required', 'in:pending,approved,disapproved,suspended'],
            'commission_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $seller->update([
            'status'          => $data['status'],
            'commission_rate' => $data['commission_rate'] ?? null,
        ]);

        return redirect()
            ->route('marketplace.admin.sellers.index')
            ->with('success', 'Seller updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        Seller::findOrFail($id)->delete();

        return redirect()
            ->route('marketplace.admin.sellers.index')
            ->with('success', 'Seller removed.');
    }
}
