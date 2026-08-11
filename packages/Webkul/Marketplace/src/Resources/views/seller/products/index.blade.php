@extends('marketplace::layouts.seller')

@section('page_title', 'My Products')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold">My Products</h1>
    <a href="{{ route('marketplace.seller.products.create') }}" class="bg-gray-900 text-white rounded px-4 py-2 text-sm">Add Product</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-3">SKU</th>
                <th class="px-4 py-3">Type</th>
                <th class="px-4 py-3">Approval</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $product->sku }}</td>
                    <td class="px-4 py-3">{{ $product->type }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-xs
                            @class([
                                'bg-yellow-100 text-yellow-800' => $product->approval_status === 'pending',
                                'bg-green-100 text-green-800' => $product->approval_status === 'approved',
                                'bg-red-100 text-red-800' => $product->approval_status === 'disapproved',
                            ])">
                            {{ ucfirst($product->approval_status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('marketplace.seller.products.edit', $product->id) }}" class="underline mr-3">Edit</a>
                        <form action="{{ route('marketplace.seller.products.destroy', $product->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Delete this product?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">No products yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $products->links() }}</div>
@endsection
