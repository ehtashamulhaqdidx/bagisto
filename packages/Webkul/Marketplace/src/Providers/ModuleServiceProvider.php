<?php

namespace Webkul\Marketplace\Providers;

use Webkul\Core\Providers\CoreModuleServiceProvider;
use Webkul\Marketplace\Models\ProductSeller;
use Webkul\Marketplace\Models\Seller;
use Webkul\Marketplace\Models\SellerTranslation;
use Webkul\Marketplace\Models\SellerProxy;
use Webkul\Marketplace\Models\SellerTranslationProxy;
use Webkul\Marketplace\Models\ProductSellerProxy;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    /**
     * Models.
     *
     * @var array
     */
    protected $models = [
        Seller::class,
        SellerTranslation::class,
        ProductSeller::class,
    ];

    protected $proxies = [
        SellerProxy::class,
        SellerTranslationProxy::class,
        ProductSellerProxy::class,
    ];
}
