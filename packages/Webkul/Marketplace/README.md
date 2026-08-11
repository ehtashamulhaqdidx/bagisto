# Bagisto Marketplace (Custom)

A self-built multivendor package for Bagisto. Adds seller registration/approval,
seller-scoped products, order splitting, shipments, invoices, commission tracking,
and payouts.

This is **not** Webkul's official paid Marketplace extension — it's a custom
package built to give you the same core capabilities for free, using Bagisto's
own package conventions so it drops into your existing `bagisto/bagisto` clone.

---

## 1. Copy the package in

Copy this whole `Marketplace` folder into your Bagisto project at:

```
packages/Webkul/Marketplace
```

So you end up with `packages/Webkul/Marketplace/src/...` alongside your other
`packages/Webkul/*` folders (Product, Sales, Customer, etc.).

## 2. Register the namespace

In your Bagisto root `composer.json`, add this under `"autoload" > "psr-4"`:

```json
"Webkul\\Marketplace\\": "packages/Webkul/Marketplace/src"
```

## 3. Register the service provider

In `bootstrap/providers.php`, add:

```php
Webkul\Marketplace\Providers\MarketplaceServiceProvider::class,
```

## 4. Add the `seller` auth guard

Bagisto sellers are a separate auth entity from customers/admins. Open
`config/auth.php` and add:

```php
'guards' => [
    // ...existing guards (web, admin, customer)...
    'seller' => [
        'driver'   => 'session',
        'provider' => 'sellers',
    ],
],

'providers' => [
    // ...existing providers...
    'sellers' => [
        'driver' => 'eloquent',
        'model'  => Webkul\Marketplace\Models\Seller::class,
    ],
],
```

## 5. Run install

```bash
composer dump-autoload
php artisan marketplace:install
php artisan optimize:clear
```

This runs the package migrations (creates `sellers`, `marketplace_commissions`,
`marketplace_payouts`, and adds `seller_id` columns to `products`,
`order_items`, `shipments`, and `invoices`).

## 6. Verify

- Seller registration: `/marketplace/seller/register`
- Seller login: `/marketplace/seller/login`
- Admin seller list: `/admin/marketplace/sellers`
- Admin commissions: `/admin/marketplace/commissions`
- Admin payouts: `/admin/marketplace/payouts`

New sellers land in `pending` status. Approve them from
`/admin/marketplace/sellers` before they can access their dashboard.

---

## Things you will very likely need to adjust

I wrote this against Bagisto's documented package conventions and typical
core model/repository names, but **I don't have your actual codebase to
verify against**, so a few integration points need a quick check on your end:

1. **Event name for commission generation.**
   `MarketplaceServiceProvider::registerEventListeners()` listens on
   `sales.invoice.save.after` to auto-generate commission ledger entries when
   an invoice is created. Check your installed Bagisto version's
   `InvoiceRepository` to confirm this event name — if it differs, update the
   string in that method.

2. **Core model/repository namespaces.**
   Controllers reference `Webkul\Product\Models\Product`,
   `Webkul\Product\Repositories\ProductRepository`, `Webkul\Sales\Models\Order`,
   `Webkul\Sales\Repositories\ShipmentRepository`, and
   `Webkul\Sales\Repositories\InvoiceRepository`. These match Bagisto's
   published package structure, but double-check against your version.

3. **Admin layout path.**
   Admin views `@extend('admin::layouts.master')`. If your Bagisto admin
   theme uses a different master layout name, update the `@extends` line in
   `Resources/views/admin/**/*.blade.php`.

4. **Order/checkout seller assignment.**
   This package adds `seller_id` to `order_items`, but doesn't include a
   listener that stamps it automatically when an order is placed — you'll
   want to add a small listener on order creation that copies
   `seller_id` from each ordered product onto the corresponding order item
   (a few lines, happy to add this next).

5. **Storefront product listing filter.**
   Nothing here filters storefront product listings by `approval_status`.
   Add a global scope or query filter in your Product listing repository
   so `approval_status = pending` products stay hidden from shoppers.

6. **Seller product create/edit UI.**
   The create/edit forms are intentionally minimal (SKU, type, attribute
   family). Bagisto's real product form is attribute-driven — extend the
   `edit.blade.php` to loop `$product->attribute_family->attribute_groups`
   the same way Bagisto's own admin product edit page does, if you want full
   parity.

None of this is exotic — it's normal follow-up work you'd do wiring any
custom package into an existing app, just flagging it up front so nothing's
a surprise on `composer dump-autoload`.

---

## What's included

```
Marketplace/
├── README.md
└── src/
    ├── Config/marketplace.php
    ├── Console/Commands/MarketplaceInstall.php
    ├── Database/Migrations/           (sellers, commissions, payouts, seller_id columns)
    ├── Http/Controllers/Admin/        (SellerController, CommissionController, PayoutController)
    ├── Http/Controllers/Seller/       (Auth, Dashboard, Product, Order, Shipment, Invoice, Payout)
    ├── Http/Middleware/Seller.php     (auth:seller + approved-status gate)
    ├── Listeners/GenerateCommission.php
    ├── Models/                        (Seller, Commission, Payout)
    ├── Providers/MarketplaceServiceProvider.php
    ├── Repositories/                  (Seller, Commission, Payout)
    ├── Resources/views/               (seller panel + admin panel views)
    └── Routes/                        (seller-routes.php, admin-routes.php)
```

## Config

`config/marketplace.php` (published on install):

```php
'commission.default_rate'         // global commission %, e.g. 10
'product.approval_required'       // whether new seller products need approval
'seller.approval_required'        // whether new sellers need approval
'payout.minimum_amount'           // minimum payout request amount
```

Override any of these via `.env`:
`MARKETPLACE_DEFAULT_COMMISSION_RATE`, `MARKETPLACE_PRODUCT_APPROVAL_REQUIRED`,
`MARKETPLACE_SELLER_APPROVAL_REQUIRED`, `MARKETPLACE_MINIMUM_PAYOUT`.
