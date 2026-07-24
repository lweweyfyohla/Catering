<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Supplier Portal - CaterSource' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-[#f6f7fb] font-sans antialiased text-slate-800">

<header class="bg-white border-b border-slate-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-8 py-4 flex items-center justify-between">

        <div class="flex items-center gap-2">
            <div class="h-9 w-9 rounded-lg bg-brand-500 flex items-center justify-center text-white font-bold">
                C
            </div>

            <div>
                <span class="text-lg font-semibold text-slate-900 block leading-tight">
                    CaterSource
                </span>
                <span class="text-xs text-slate-400">
                    Supplier Portal
                </span>
            </div>
        </div>

        <nav class="hidden sm:flex items-center gap-1">

            <a href="{{ route('supplier.dashboard') }}"
               class="rounded-lg px-3 py-2 text-sm font-medium
               {{ request()->routeIs('supplier.dashboard') ? 'bg-brand-50 text-brand-600' : 'text-slate-500 hover:bg-slate-50' }}">
                Dashboard
            </a>

            <a href="{{ route('supplier.quotations.index') }}"
               class="rounded-lg px-3 py-2 text-sm font-medium
               {{ request()->routeIs('supplier.quotations.*') ? 'bg-brand-50 text-brand-600' : 'text-slate-500 hover:bg-slate-50' }}">
                Quote Requests
            </a>

            <a href="{{ route('supplier.menu-items.index') }}"
               class="rounded-lg px-3 py-2 text-sm font-medium
               {{ request()->routeIs('supplier.menu-items.*') ? 'bg-brand-50 text-brand-600' : 'text-slate-500 hover:bg-slate-50' }}">
                My Menu
            </a>

        </nav>

        <div class="flex items-center gap-4">

            <div class="text-right hidden sm:block">
                <p class="text-sm font-medium text-slate-900">
                    {{ auth()->user()->name }}
                </p>

                <p class="text-xs text-slate-400">
                    {{ auth()->user()->supplier?->name }}
                </p>
            </div>

            <div class="h-9 w-9 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-semibold text-sm">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="text-xs font-medium text-slate-400 hover:text-brand-600">
                    Log out
                </button>
            </form>

        </div>

    </div>
</header>

<main class="max-w-5xl mx-auto px-4 sm:px-8 py-8">

    <div class="mb-6">
        <h1 class="text-lg font-semibold text-slate-900">
            {{ $pageTitle ?? 'Supplier Portal' }}
        </h1>

        <p class="text-sm text-slate-400">
            {{ $pageSubtitle ?? now()->format('l, F j, Y') }}
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 border border-red-100 text-red-700 text-sm px-4 py-3">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ $slot }}

</main>

</body>
</html>