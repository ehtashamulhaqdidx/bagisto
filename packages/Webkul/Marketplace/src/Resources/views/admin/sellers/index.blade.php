{{-- Drop this content into your admin theme's content block, e.g.:
     @extends('admin::layouts.master')  @section('content') ... @endsection
     Adjust the extends path to match your installed Bagisto admin theme. --}}
@extends('admin::layouts.master')

@section('page_title', 'Marketplace Sellers')

@section('content')
<div class="max-w-6xl mx-auto py-6">
    <h1 class="text-2xl font-semibold mb-6">Marketplace Sellers</h1>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-3">Shop</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Commission %</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sellers as $seller)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $seller->shop_title }}</td>
                        <td class="px-4 py-3">{{ $seller->email }}</td>
                        <td class="px-4 py-3">{{ ucfirst($seller->status) }}</td>
                        <td class="px-4 py-3">{{ $seller->commission_rate ?? 'default' }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('marketplace.admin.sellers.edit', $seller->id) }}" class="underline">Manage</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No sellers yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $sellers->links() }}</div>
</div>
@endsection
