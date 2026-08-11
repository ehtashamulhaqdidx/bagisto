@extends('marketplace::layouts.seller')

@section('page_title', 'Seller Login')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow p-8">
    <h1 class="text-xl font-semibold mb-6">Seller Login</h1>

    <form method="POST" action="{{ route('marketplace.seller.login.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm mb-1">Password</label>
            <input type="password" name="password" required class="w-full border rounded px-3 py-2">
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="remember"> Remember me
        </label>

        <button type="submit" class="w-full bg-gray-900 text-white rounded py-2">Login</button>
    </form>

    <p class="text-sm mt-4">
        No shop yet?
        <a href="{{ route('marketplace.seller.register') }}" class="underline">Become a seller</a>
    </p>
</div>
@endsection
