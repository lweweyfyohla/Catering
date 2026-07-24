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

    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search suppliers..."
               class="rounded-lg border-slate-200 text-sm w-64 focus:border-brand-400 focus:ring-brand-400">
        <select name="category" onchange="this.form.submit()" class="rounded-lg border-slate-200 text-sm focus:border-brand-400 focus:ring-brand-400">
            <option value="all">All categories</option>
            @foreach (['catering','beverage','dessert','other'] as $c)
                <option value="{{ $c }}" @selected(request('category') === $c)>{{ ucfirst($c) }}</option>
            @endforeach
        </select>
        <button class="rounded-lg border border-slate-200 text-slate-600 text-sm font-medium px-4 py-2 hover:bg-slate-50">Filter</button>
    </form>

    @if ($suppliers->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm px-6 py-12 text-center text-sm text-slate-400">
            No suppliers found yet.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($suppliers as $supplier)
                <a href="{{ route('suppliers.show', $supplier) }}" class="block bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition">
                    <div class="h-28 bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center">
                        <span class="text-2xl font-bold text-brand-500">{{ strtoupper(substr($supplier->name, 0, 2)) }}</span>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-slate-900">{{ $supplier->name }}</h3>
                            <span class="text-xs font-medium text-amber-500 flex items-center gap-1">
                                ★ {{ number_format($supplier->stars, 1) }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">{{ ucfirst($supplier->category) }} &middot; {{ $supplier->address ?? 'No address' }}</p>
                        <p class="text-xs text-slate-400 mt-2">{{ $supplier->menu_items_count }} menu items</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</x-layouts.app>