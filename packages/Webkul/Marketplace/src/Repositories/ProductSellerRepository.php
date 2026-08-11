<?php

namespace Webkul\Marketplace\Repositories;

use Webkul\Core\Eloquent\Repository;
use Webkul\Marketplace\Contracts\ProductSeller;

class ProductSellerRepository extends Repository
{
    public function model(): string
    {
        return ProductSeller::class;
    }
}
