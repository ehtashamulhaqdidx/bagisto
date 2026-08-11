@extends('marketplace::layouts.seller')

@section('page_title', 'Become a Seller')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-lg shadow p-8">
    <h1 class="text-xl font-semibold mb-6">Become a Seller</h1>

    <form method="POST" action="{{ route('marketplace.seller.register.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm mb-1">Your Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1">Password</label>
                <input type="password" name="password" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div>
            <label class="block text-sm mb-1">Shop Title</label>
            <input type="text" name="shop_title" value="{{ old('shop_title') }}" required class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm mb-1">Shop URL</label>
            <input type="text" name="shop_url" value="{{ old('shop_url') }}" required
                   placeholder="my-cool-shop" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm mb-1">Phone (optional)</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded px-3 py-2">
        </div>

        <button type="submit" class="w-full bg-gray-900 text-white rounded py-2">Create Seller Account</button>
    </form>

    <p class="text-sm mt-4">
        Already a seller?
        <a href="{{ route('marketplace.seller.login') }}" class="underline">Log in</a>
    </p>
</div>
@endsection
