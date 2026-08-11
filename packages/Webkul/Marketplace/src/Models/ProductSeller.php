<?php

namespace Webkul\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Marketplace\Contracts\ProductSeller as ProductSellerContract;
use Webkul\Product\Models\ProductProxy;
use Webkul\Marketplace\Models\SellerProxy;

class ProductSeller extends Model implements ProductSellerContract
{
    protected $table = 'marketplace_product_sellers';

    protected $fillable = [
        'product_id',
        'seller_id',
        'status',
        'is_approved',
    ];

    public function product()
    {
        return $this->belongsTo(ProductProxy::modelClass(), 'product_id');
    }

    public function seller()
    {
        return $this->belongsTo(SellerProxy::modelClass(), 'seller_id');
    }
}
