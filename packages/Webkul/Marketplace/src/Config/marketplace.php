<?php

return [
    'commission' => [
        // Global default commission percentage applied to sellers without
        // an individual commission_rate override on their seller record.
        'default_rate' => env('MARKETPLACE_DEFAULT_COMMISSION_RATE', 10),
    ],

    'product' => [
        // Whether seller-created products require admin approval before
        // becoming purchasable / visible in storefront listings.
        'approval_required' => env('MARKETPLACE_PRODUCT_APPROVAL_REQUIRED', true),
    ],

    'seller' => [
        // Whether new seller registrations require admin approval before
        // the seller can access their dashboard.
        'approval_required' => env('MARKETPLACE_SELLER_APPROVAL_REQUIRED', true),
    ],

    'payout' => [
        // Minimum amount a seller may request as a payout.
        'minimum_amount' => env('MARKETPLACE_MINIMUM_PAYOUT', 10),
    ],
];
