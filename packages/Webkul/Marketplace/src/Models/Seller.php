<?php

namespace Webkul\Marketplace\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Webkul\Customer\Models\CustomerProxy;
use Webkul\Marketplace\Contracts\Seller as SellerContract;
use Webkul\Core\Eloquent\TranslatableModel;

class Seller extends TranslatableModel implements SellerContract
{
    use HasFactory;

    protected $table = 'marketplace_sellers';

    protected $fillable = [
        'customer_id',
        'shop_title',
        'shop_description',
        'is_approved',
        'commission_rate',
        'status',
    ];

    public $translatedAttributes = [
        'shop_title',
        'shop_description',
    ];

    protected $with = ['translations'];

    public function sellerProducts()
    {
        return $this->hasMany(ProductSeller::class, 'seller_id');
    }

    public function customer()
    {
        return $this->belongsTo(CustomerProxy::modelClass(), 'customer_id');
    }
}
