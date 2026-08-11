<?php

namespace Webkul\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commission extends Model
{
    protected $table = 'marketplace_commissions';

    protected $fillable = [
        'seller_id', 'order_id', 'order_item_id', 'invoice_id',
        'item_total', 'commission_rate', 'commission_amount', 'seller_earning',
        'status',
    ];

    protected $casts = [
        'item_total'         => 'decimal:4',
        'commission_rate'    => 'decimal:2',
        'commission_amount'  => 'decimal:4',
        'seller_earning'     => 'decimal:4',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
}
