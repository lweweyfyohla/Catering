<x-layouts.app title="Suppliers - CaterSource" page-title="Suppliers" :page-subtitle="now()->format('l, F j, Y')">

    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-slate-500">Browse suppliers and their menus</p>
        <div class="flex items-center gap-3">
            <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-50 text-brand-600 text-sm font-medium px-4 py-2.5 hover:bg-brand-100">
                <x-nav-icon name="cart" />
                View Cart
            </a>
        </div>
    </div>

    <form method="GET" class="flex flex-wrap items-center gap-3 mb-6">
        <div class="relative">
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search suppliers..."
                   onchange="this.form.submit()"
                   class="rounded-lg border border-slate-300 text-sm w-64 pl-9 pr-3 py-2.5 focus:border-brand-400 focus:ring-brand-400 focus:ring-1">
        </div>

        <div class="relative">
            <select name="category" onchange="this.form.submit()"
                    class="appearance-none rounded-lg border border-slate-300 text-sm font-medium text-slate-700 pl-3 pr-9 py-2.5 bg-white hover:border-slate-400 focus:border-brand-400 focus:ring-brand-400 focus:ring-1 cursor-pointer">
                <option value="all">All categories</option>
                @foreach (['catering','beverage','dessert','other'] as $c)
                    <option value="{{ $c }}" @selected(request('category') === $c)>{{ ucfirst($c) }}</option>
                @endforeach
            </select>
            <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>
    </form>
    @if ($suppliers->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm px-6 py-12 text-center text-sm text-slate-400">
            No suppliers found yet.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($suppliers as $supplier)
                <a href="{{ route('suppliers.show', $supplier) }}" class="block bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition">
    <div class="p-4 flex items-center gap-3">
        <div class="h-8 w-8 rounded-full ring-1 ring-slate-100 bg-brand-50 overflow-hidden flex items-center justify-center shrink-0">
            @if ($supplier->logo)
                <img src="{{ asset('storage/'.$supplier->logo) }}" class="h-full w-full object-cover" alt="{{ $supplier->name }} logo">
            @else
                <span class="text-xs font-bold text-brand-500">{{ strtoupper(substr($supplier->name, 0, 2)) }}</span>
            @endif
        </div>
        <div class="min-w-0 flex-1">
            <h3 class="font-semibold text-slate-900 truncate">{{ $supplier->name }}</h3>
            <span class="inline-block mt-1 text-[11px] font-medium text-slate-500 bg-slate-100 rounded-full px-2 py-0.5">{{ ucfirst($supplier->category) }}</span>
        </div>
        <span class="text-xs font-medium text-amber-500 flex items-center gap-1 shrink-0">
            ★ {{ number_format($supplier->stars, 1) }}
        </span>
    </div>

    <div class="h-28 bg-gradient-to-br from-brand-100 to-brand-50 overflow-hidden">
        @if ($supplier->image_cover)
            <img src="{{ asset('storage/'.$supplier->image_cover) }}" class="h-full w-full object-cover object-center" alt="{{ $supplier->name }} cover">
        @endif
    </div>

    <div class="px-4 py-3">
        <p class="text-xs text-slate-400">{{ $supplier->address ?? 'No address' }}</p>
        <p class="text-xs text-slate-400 mt-1">{{ $supplier->menu_items_count }} menu items</p>
    </div>
</a>
            @endforeach
        </div>
    @endif
</x-layouts.app>