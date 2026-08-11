<?php

namespace Webkul\Marketplace\Repositories;

use Webkul\Marketplace\Models\Commission;
use Webkul\Marketplace\Models\Seller;

class CommissionRepository
{
    /**
     * Create a commission ledger entry for a single order item sold by a seller,
     * and mark it payable immediately (invoice already generated at this point).
     */
    public function recordForOrderItem(Seller $seller, int $orderId, int $orderItemId, ?int $invoiceId, float $itemTotal): Commission
    {
        $rate = $seller->commissionRate();
        $commissionAmount = round($itemTotal * ($rate / 100), 4);
        $sellerEarning = round($itemTotal - $commissionAmount, 4);

        return Commission::updateOrCreate(
            ['order_item_id' => $orderItemId],
            [
                'seller_id'         => $seller->id,
                'order_id'          => $orderId,
                'invoice_id'        => $invoiceId,
                'item_total'        => $itemTotal,
                'commission_rate'   => $rate,
                'commission_amount' => $commissionAmount,
                'seller_earning'    => $sellerEarning,
                'status'            => 'payable',
            ]
        );
    }

    public function paginateForSeller(int $sellerId, int $perPage = 20)
    {
        return Commission::where('seller_id', $sellerId)->latest()->paginate($perPage);
    }

    public function paginateForAdmin(int $perPage = 20)
    {
        return Commission::with('seller')->latest()->paginate($perPage);
    }
}
