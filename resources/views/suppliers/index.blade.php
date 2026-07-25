<x-layouts.app title="Suppliers - CaterSource" page-title="Suppliers" :page-subtitle="now()->format('l, F j, Y')">

    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-slate-500">Browse suppliers and their menus</p>
        <div class="flex items-center gap-3">
            <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-4 py-2.5 transition">
                <x-nav-icon name="cart" />
                View Cart
            </a>
        </div>
    </div>


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