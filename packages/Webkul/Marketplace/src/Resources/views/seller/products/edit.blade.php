@extends('marketplace::layouts.seller')

@section('page_title', 'Edit Product')

@section('content')
<div class="max-w-lg bg-white rounded-lg shadow p-8">
    <h1 class="text-xl font-semibold mb-6">Edit Product #{{ $product->id }}</h1>

    <form method="POST" action="{{ route('marketplace.seller.products.update', $product->id) }}" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm mb-1">SKU</label>
            <input type="text" name="sku" value="{{ $product->sku }}" class="w-full border rounded px-3 py-2">
        </div>

        {{-- Extend with attribute-driven fields (name, price, description, images)
             pulled from $product->attribute_family, matching how Bagisto's
             own admin product edit form iterates attributes dynamically. --}}

        <button type="submit" class="w-full bg-gray-900 text-white rounded py-2">Save Changes</button>
    </form>
</div>
@endsection
