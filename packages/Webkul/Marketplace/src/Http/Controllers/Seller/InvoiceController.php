<?php

namespace Webkul\Marketplace\Http\Controllers\Seller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Repositories\InvoiceRepository;

class InvoiceController extends Controller
{
    public function __construct(protected InvoiceRepository $invoiceRepository)
    {
    }

    /**
     * Generates an invoice for only this seller's items on the order.
     * Commission ledger entries are created automatically via the
     * GenerateCommission listener bound to the invoice-save event.
     */
    public function store(Request $request, int $orderId): RedirectResponse
    {
        $seller = Auth::guard('seller')->user();

        $order = Order::whereHas('items', function ($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        })->findOrFail($orderId);

        $sellerItemIds = $order->items()->where('seller_id', $seller->id)->pluck('id')->all();

        $requestedItems = collect($request->input('items', []))
            ->filter(fn ($qty, $itemId) => in_array((int) $itemId, $sellerItemIds, true) && $qty > 0);

        abort_if($requestedItems->isEmpty(), 422, 'No valid items selected for invoicing.');

        $invoice = $this->invoiceRepository->create([
            'order_id' => $order->id,
            'items'    => $requestedItems->toArray(),
        ]);

        $invoice->update(['seller_id' => $seller->id]);

        return redirect()
            ->route('marketplace.seller.orders.show', $order->id)
            ->with('success', 'Invoice generated.');
    }
}
