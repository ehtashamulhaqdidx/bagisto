<?php

namespace Webkul\Marketplace\Repositories;

use Webkul\Core\Eloquent\Repository;
use Webkul\Marketplace\Contracts\Seller;

class SellerRepository extends Repository
{
    public function model(): string
    {
        return Seller::class;
    }
}
