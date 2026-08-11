<?php

namespace Webkul\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Marketplace\Contracts\SellerTranslation as SellerTranslationContract;

class SellerTranslation extends Model implements SellerTranslationContract
{
    public $timestamps = false;

    protected $table = 'marketplace_seller_translations';

    protected $fillable = [
        'shop_title',
        'shop_description',
    ];
}
