<x-layouts.app title="Cart - CaterSource" page-title="Cart Items" :page-subtitle="now()->format('l, F j, Y')">

    <a href="{{ route('suppliers.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-brand-600 mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to suppliers
    </a>

    @if ($cartItems->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm px-6 py-16 text-center text-sm text-slate-400">
            Your cart is empty. Browse suppliers to add menu items for your events.
        </div>
    @else
        <div class="space-y-6">
            @foreach ($cartItems as $group)
                @php
                    $first = $group->first();
                    $event = $first->event;
                    $supplier = $first->menuItem->supplier;
                    $total = $group->sum('total_price');
                @endphp
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-2">
                        <div>
                            <p class="text-xs text-slate-400">Supplier</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $supplier->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Event</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $event->event_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Event date</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $event->event_date->format('M j, Y') }}</p>
                        </div>
                    </div>

                    <div class="divide-y divide-slate-50">
                        @foreach ($group as $cartItem)
                            <div class="px-6 py-4 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="h-12 w-12 rounded-lg bg-slate-50 flex items-center justify-center shrink-0 overflow-hidden">
                                        @if ($cartItem->menuItem->image)
                                            <img src="{{ asset('storage/'.$cartItem->menuItem->image) }}" class="h-full w-full object-cover">
                                        @else
                                            <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 6h16v12H4V6z"/></svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-slate-800 truncate">{{ $cartItem->menuItem->item_name }}</p>
                                        <p class="text-xs text-slate-400">${{ number_format($cartItem->unit_price, 2) }} each</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 shrink-0">
                                    <form method="POST" action="{{ route('cart.update', $cartItem) }}" class="flex items-center gap-1">
                                        @csrf @method('PUT')
                                        <span class="text-xs text-slate-400">x</span>
                                        <input type="number" name="quantity" value="{{ $cartItem->quantity }}" min="1"
                                               onchange="this.form.submit()"
                                               class="w-16 rounded-lg border-slate-200 text-sm py-1">
                                    </form>
                                    <p class="text-sm font-semibold text-slate-800 w-20 text-right">${{ number_format($cartItem->total_price, 2) }}</p>
                                    <form method="POST" action="{{ route('cart.destroy', $cartItem) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-slate-300 hover:text-red-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="px-6 py-4 bg-slate-50 flex items-center justify-between">
                        <p class="text-sm font-semibold text-slate-700">Total Amount</p>
                        <p class="text-brand-600 font-bold">${{ number_format($total, 2) }}</p>
                    </div>

                    <div class="px-6 py-4 border-t border-slate-100 flex justify-end">
                        <a href="{{ route('quotations.compare', $event) }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-4 py-2.5">
                            Save quote
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-layouts.app>
