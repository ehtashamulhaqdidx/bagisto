@extends('admin::layouts.master')

@section('page_title', 'Manage Seller')

@section('content')
<div class="max-w-lg mx-auto py-6">
    <h1 class="text-2xl font-semibold mb-6">{{ $seller->shop_title }}</h1>

    <form method="POST" action="{{ route('marketplace.admin.sellers.update', $seller->id) }}" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm mb-1">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                @foreach (['pending', 'approved', 'disapproved', 'suspended'] as $status)
                    <option value="{{ $status }}" @selected($seller->status === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm mb-1">Commission Rate % (leave blank for global default)</label>
            <input type="number" step="0.01" name="commission_rate" value="{{ $seller->commission_rate }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <button type="submit" class="bg-gray-900 text-white rounded px-4 py-2 text-sm">Save</button>
    </form>
</div>
@endsection
