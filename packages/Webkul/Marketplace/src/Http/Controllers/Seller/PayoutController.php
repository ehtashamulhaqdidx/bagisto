<?php

namespace Webkul\Marketplace\Http\Controllers\Seller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Webkul\Marketplace\Repositories\PayoutRepository;

class PayoutController extends Controller
{
    public function __construct(protected PayoutRepository $payoutRepository)
    {
    }

    public function index(): View
    {
        $seller = Auth::guard('seller')->user();

        $payouts = $this->payoutRepository->paginateForSeller($seller->id);

        return view('marketplace::seller.payouts.index', [
            'payouts' => $payouts,
            'available_balance' => $seller->availableBalance(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $seller = Auth::guard('seller')->user();

        $data = $request->validate([
            'amount'         => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['nullable', 'string', 'max:255'],
        ]);

        abort_if($data['amount'] > $seller->availableBalance(), 422, 'Requested amount exceeds available balance.');

        $this->payoutRepository->request($seller, (float) $data['amount'], $data['payment_method'] ?? null);

        return redirect()
            ->route('marketplace.seller.payouts.index')
            ->with('success', 'Payout requested.');
    }
}
