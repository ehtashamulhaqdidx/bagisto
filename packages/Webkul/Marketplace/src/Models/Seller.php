<?php

namespace Webkul\Marketplace\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webkul\Product\Models\Product;
use Webkul\Marketplace\Models\Commission;
use Webkul\Marketplace\Models\Payout;

class Seller extends Authenticatable
{
    use HasFactory;

    protected $table = 'sellers';

    protected $fillable = [
        'name', 'email', 'password',
        'shop_title', 'shop_url', 'phone', 'business_description',
        'logo_path', 'banner_path',
        'address', 'city', 'state', 'country', 'postcode',
        'status', 'commission_rate', 'is_featured',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_featured'        => 'boolean',
        'commission_rate'    => 'decimal:2',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class, 'seller_id');
    }

    public function payouts(): HasMany
    {
        return $this->hasMany(Payout::class, 'seller_id');
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Effective commission rate: seller-specific override, else global config default.
     */
    public function commissionRate(): float
    {
        return (float) ($this->commission_rate ?? config('marketplace.commission.default_rate', 10));
    }

    public function availableBalance(): float
    {
        $earned = $this->commissions()->where('status', 'payable')->sum('seller_earning');
        $paidOut = $this->payouts()->whereIn('status', ['approved', 'paid'])->sum('amount');

        return round((float) $earned - (float) $paidOut, 2);
    }
}
