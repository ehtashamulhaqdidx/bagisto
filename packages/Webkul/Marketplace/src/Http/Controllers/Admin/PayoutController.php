<?php

namespace Webkul\Marketplace\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Webkul\Marketplace\Models\Payout;
use Webkul\Marketplace\Repositories\PayoutRepository;

class PayoutController extends Controller
{
    public function __construct(protected PayoutRepository $payoutRepository)
    {
    }

    public function index(): View
    {
        $payouts = $this->payoutRepository->paginateForAdmin();

        return view('marketplace::admin.payouts.index', compact('payouts'));
    }

    public function approve(int $id): RedirectResponse
    {
        $payout = Payout::findOrFail($id);

        $this->payoutRepository->approve($payout);

        return back()->with('success', 'Payout approved.');
    }

    public function reject(Request $request, int $id): RedirectResponse
    {
        $payout = Payout::findOrFail($id);

        $this->payoutRepository->reject($payout, $request->input('note'));

        return back()->with('success', 'Payout rejected.');
    }

    public function markPaid(int $id): RedirectResponse
    {
        $payout = Payout::findOrFail($id);

        $this->payoutRepository->markPaid($payout);

        return back()->with('success', 'Payout marked as paid.');
    }
}
