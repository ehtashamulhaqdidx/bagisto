<?php

namespace Webkul\Marketplace\Repositories;

use Illuminate\Support\Facades\Hash;
use Webkul\Marketplace\Models\Seller;

class SellerRepository
{
    public function model(): string
    {
        return Seller::class;
    }

    public function create(array $data): Seller
    {
        $data['password'] = Hash::make($data['password']);
        $data['status'] = 'pending';

        return Seller::create($data);
    }

    public function findByEmail(string $email): ?Seller
    {
        return Seller::where('email', $email)->first();
    }

    public function paginateForAdmin(?string $status = null, int $perPage = 20)
    {
        return Seller::when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate($perPage);
    }

    public function approve(Seller $seller): Seller
    {
        $seller->update(['status' => 'approved']);

        return $seller;
    }

    public function disapprove(Seller $seller): Seller
    {
        $seller->update(['status' => 'disapproved']);

        return $seller;
    }

    public function suspend(Seller $seller): Seller
    {
        $seller->update(['status' => 'suspended']);

        return $seller;
    }

    public function setCommissionRate(Seller $seller, ?float $rate): Seller
    {
        $seller->update(['commission_rate' => $rate]);

        return $seller;
    }
}
