<x-layouts.app title="Compare Quotes - CaterSource" page-title="Compare Quotes" :page-subtitle="$event->event_name">

    <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-brand-600 mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to cart
    </a>

    <p class="text-sm text-slate-500 mb-6">Compare estimated totals from each supplier currently in your cart for <strong>{{ $event->event_name }}</strong>, then send the quote request to the best option.</p>

    @if ($estimates->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm px-6 py-12 text-center text-sm text-slate-400">
            No items in your cart for this event yet.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($estimates as $index => $estimate)
                <div class="bg-white rounded-2xl border {{ $index === 0 ? 'border-brand-400 ring-1 ring-brand-100' : 'border-slate-100' }} shadow-sm p-5 relative">
                    @if ($index === 0)
                        <span class="absolute top-4 right-4 status-pill bg-brand-50 text-brand-600">Best value</span>
                    @endif
                    <p class="text-sm font-semibold text-slate-900">{{ $estimate->supplier_name }}</p>
                    <p class="text-xs text-slate-400 mb-3">{{ $event->event_name }}</p>
                    <p class="text-2xl font-bold text-brand-600">${{ number_format($estimate->estimated_total, 2) }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $estimate->item_count }} item(s)</p>

                    <form method="POST" action="{{ route('quotations.store', $event) }}" class="mt-4 space-y-3">
                        @csrf
                        <input type="hidden" name="supplier_id" value="{{ $estimate->supplier_id }}">
                        <textarea name="notes" rows="2" placeholder="Notes for supplier (optional)" class="w-full rounded-lg border-slate-200 text-xs"></textarea>
                        <div class="flex items-center gap-2">
                            <button type="submit" class="flex-1 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium py-2">Order</button>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</x-layouts.app>
