{{-- Standalone layout for the seller panel. If your Bagisto shop theme
     already exposes a base layout (e.g. shop::layouts.default), you can
     swap the <html>...<body> boilerplate below for an @extends instead. --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('page_title', 'Seller Panel') - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    @auth('seller')
    <nav class="bg-white border-b px-6 py-4 flex items-center justify-between">
        <a href="{{ route('marketplace.seller.dashboard') }}" class="font-semibold text-lg">
            {{ auth('seller')->user()->shop_title }}
        </a>
        <div class="flex gap-4 text-sm">
            <a href="{{ route('marketplace.seller.dashboard') }}" class="hover:underline">Dashboard</a>
            <a href="{{ route('marketplace.seller.products.index') }}" class="hover:underline">Products</a>
            <a href="{{ route('marketplace.seller.orders.index') }}" class="hover:underline">Orders</a>
            <a href="{{ route('marketplace.seller.payouts.index') }}" class="hover:underline">Payouts</a>
            <form action="{{ route('marketplace.seller.logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="hover:underline">Logout</button>
            </form>
        </div>
    </nav>
    @endauth

    <main class="max-w-6xl mx-auto px-6 py-8">
        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-800 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
