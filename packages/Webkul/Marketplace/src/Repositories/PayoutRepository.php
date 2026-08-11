<?php

namespace Webkul\Marketplace\Repositories;

use Webkul\Marketplace\Models\Payout;
use Webkul\Marketplace\Models\Seller;

class PayoutRepository
{
    public function request(Seller $seller, float $amount, ?string $method = null): Payout
    {
        return Payout::create([
            'seller_id'      => $seller->id,
            'amount'         => $amount,
            'payment_method' => $method,
            'status'         => 'requested',
        ]);
    }

    public function approve(Payout $payout): Payout
    {
        $payout->update(['status' => 'approved']);

        return $payout;
    }

    public function reject(Payout $payout, ?string $note = null): Payout
    {
        $payout->update(['status' => 'rejected', 'admin_note' => $note]);

        return $payout;
    }

    public function markPaid(Payout $payout): Payout
    {
        $payout->update(['status' => 'paid', 'paid_at' => now()]);

        return $payout;
    }

    public function paginateForSeller(int $sellerId, int $perPage = 20)
    {
        return Payout::where('seller_id', $sellerId)->latest()->paginate($perPage);
    }

    public function paginateForAdmin(int $perPage = 20)
    {
        return Payout::with('seller')->latest()->paginate($perPage);
    }
}
