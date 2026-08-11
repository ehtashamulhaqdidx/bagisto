<?php

namespace Webkul\Marketplace\Http\Controllers\Seller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Webkul\Product\Models\Product;
use Webkul\Product\Repositories\ProductRepository;

class ProductController extends Controller
{
    public function __construct(protected ProductRepository $productRepository)
    {
    }

    public function index(): View
    {
        $seller = Auth::guard('seller')->user();

        $products = Product::where('seller_id', $seller->id)
            ->latest()
            ->paginate(20);

        return view('marketplace::seller.products.index', compact('products'));
    }

    public function create(): View
    {
        return view('marketplace::seller.products.create');
    }

    /**
     * Creates the product via Bagisto's own ProductRepository (so all core
     * validation, attribute handling, and indexing still runs), then stamps
     * the seller_id on it and forces it into the marketplace approval queue.
     */
    public function store(Request $request): RedirectResponse
    {
        $seller = Auth::guard('seller')->user();

        $data = $request->validate([
            'sku'          => ['required', 'string', 'unique:products,sku'],
            'type'         => ['required', 'string'],
            'attribute_family_id' => ['required', 'integer'],
        ]);

        $product = $this->productRepository->create($data);

        $product->update([
            'seller_id'       => $seller->id,
            'approval_status' => config('marketplace.product.approval_required', true) ? 'pending' : 'approved',
        ]);

        return redirect()
            ->route('marketplace.seller.products.index')
            ->with('success', 'Product created and submitted for approval.');
    }

    public function edit(int $id): View
    {
        $product = $this->authorizedProduct($id);

        return view('marketplace::seller.products.edit', compact('product'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $product = $this->authorizedProduct($id);

        $this->productRepository->update($request->all(), $product->id);

        return redirect()
            ->route('marketplace.seller.products.index')
            ->with('success', 'Product updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $product = $this->authorizedProduct($id);

        $this->productRepository->delete($product->id);

        return redirect()
            ->route('marketplace.seller.products.index')
            ->with('success', 'Product deleted.');
    }

    /**
     * Fetches a product and aborts with 403 if it doesn't belong to the logged-in seller.
     * Every product-mutating action in this controller must go through this.
     */
    protected function authorizedProduct(int $id): Product
    {
        $seller = Auth::guard('seller')->user();

        $product = Product::where('id', $id)->where('seller_id', $seller->id)->first();

        abort_if(! $product, 403, 'You do not have access to this product.');

        return $product;
    }
}
