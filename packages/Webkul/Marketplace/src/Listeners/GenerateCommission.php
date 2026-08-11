<?php

namespace Webkul\Marketplace\Listeners;

use Webkul\Marketplace\Models\Seller;
use Webkul\Marketplace\Repositories\CommissionRepository;

/**
 * Hooked into Bagisto's "sales.invoice.save.after" event.
 * When an invoice is generated for an order, walk its items and, for any
 * item that belongs to a marketplace seller, write a commission ledger entry.
 *
 * NOTE: Verify this event name against your installed Bagisto version
 * (Admin > Sales > Invoice create flow fires it from InvoiceRepository).
 * If your version uses a different event name, update the binding in
 * MarketplaceServiceProvider::boot().
 */
class GenerateCommission
{
    public function __construct(protected CommissionRepository $commissionRepository)
    {
    }

    public function handle($invoice): void
    {
        if (! $invoice || ! $invoice->items) {
            return;
        }

        foreach ($invoice->items as $invoiceItem) {
            $orderItem = $invoiceItem->order_item ?? null;

            if (! $orderItem || ! $orderItem->seller_id) {
                continue;
            }

            $seller = Seller::find($orderItem->seller_id);

            if (! $seller) {
                continue;
            }

            $itemTotal = (float) ($invoiceItem->total ?? ($invoiceItem->price * $invoiceItem->qty));

            $this->commissionRepository->recordForOrderItem(
                seller: $seller,
                orderId: $invoice->order_id,
                orderItemId: $orderItem->id,
                invoiceId: $invoice->id,
                itemTotal: $itemTotal,
            );
        }
    }
}
