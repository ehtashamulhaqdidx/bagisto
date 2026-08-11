@extends('marketplace::layouts.seller')

@section('page_title', 'Add Product')

@section('content')
<div class="max-w-lg bg-white rounded-lg shadow p-8">
    <h1 class="text-xl font-semibold mb-6">Add Product</h1>

    {{-- This intentionally covers only the minimum fields Bagisto's core
         ProductRepository needs to create a product shell. Attribute-level
         fields (name, price, description, images, etc.) are edited on the
         Edit screen afterward, same flow the admin panel uses. --}}
    <form method="POST" action="{{ route('marketplace.seller.products.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm mb-1">SKU</label>
            <input type="text" name="sku" required class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm mb-1">Product Type</label>
            <select name="type" required class="w-full border rounded px-3 py-2">
                <option value="simple">Simple</option>
                <option value="configurable">Configurable</option>
                <option value="virtual">Virtual</option>
                <option value="downloadable">Downloadable</option>
            </select>
        </div>

        <div>
            <label class="block text-sm mb-1">Attribute Family ID</label>
            <input type="number" name="attribute_family_id" required class="w-full border rounded px-3 py-2">
            <p class="text-xs text-gray-500 mt-1">Ask the admin which attribute family your product type should use.</p>
        </div>

        <button type="submit" class="w-full bg-gray-900 text-white rounded py-2">Create Product</button>
    </form>
</div>
@endsection
