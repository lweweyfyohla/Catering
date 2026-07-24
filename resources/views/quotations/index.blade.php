<x-layouts.app title="Quotations - CaterSource" page-title="Quotations" :page-subtitle="now()->format('l, F j, Y')">
  <div x-data="{ tab: 'requests' }">

    <div class="flex gap-6 border-b border-slate-100 mb-6">
        <button @click="tab = 'requests'" :class="tab === 'requests' ? 'border-brand-500 text-brand-600' : 'border-transparent text-slate-400'"
                class="pb-3 text-sm font-medium border-b-2 transition">Quote Request</button>
        <button @click="tab = 'compare'" :class="tab === 'compare' ? 'border-brand-500 text-brand-600' : 'border-transparent text-slate-400'"
                class="pb-3 text-sm font-medium border-b-2 transition">Compare Quotes</button>
    </div>

    <div x-show="tab === 'requests'" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        @php $pending = $quotations->where('status', 'pending'); @endphp
        @if ($pending->isEmpty())
            <p class="px-6 py-12 text-center text-sm text-slate-400">No quotations sent yet. Add items to your cart and request a quote from a supplier.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-slate-400 text-xs uppercase tracking-wide bg-slate-50">
                            <th class="px-6 py-3 font-medium">Event</th>
                            <th class="px-6 py-3 font-medium">Supplier</th>
                            <th class="px-6 py-3 font-medium">Sent Date</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium text-right">View</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($pending as $quotation)
                            <tr>
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $quotation->event->event_name }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $quotation->supplier->name }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $quotation->sent_at?->format('M j, Y') }}</td>
                                <td class="px-6 py-4"><x-status-badge :status="$quotation->status" /></td>
                                <td class="px-6 py-4 text-right">
                                    <button onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'quote-{{ $quotation->id }}'}))"
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-brand-600 hover:bg-brand-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z"/><circle cx="12" cy="12" r="3" stroke-width="2"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div x-show="tab === 'compare'" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        @if ($compareEvents->isEmpty())
            <p class="px-6 py-12 text-center text-sm text-slate-400">No events with items in cart yet. Add items to your cart to compare supplier quotes.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-slate-400 text-xs uppercase tracking-wide bg-slate-50">
                            <th class="px-6 py-3 font-medium">Event</th>
                            <th class="px-6 py-3 font-medium">Event Date</th>
                            <th class="px-6 py-3 font-medium">Items in Cart</th>
                            <th class="px-6 py-3 font-medium text-right">Compare</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($compareEvents as $event)
                            <tr>
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $event->event_name }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $event->event_date->format('M j, Y') }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $event->cart_items_count }} item(s)</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('quotations.compare', $event) }}"
                                       class="inline-flex items-center gap-1 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-xs font-medium px-3 py-1.5">
                                        Compare Quotes
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

  </div>

    @foreach ($quotations as $quotation)
        <x-modal :name="'quote-'.$quotation->id" max-width="md">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-900">Quote request details</h3>
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-6 py-5 grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-slate-400">Event</p>
                    <p class="text-sm font-medium text-slate-800 mt-1">{{ $quotation->event->event_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Event date</p>
                    <p class="text-sm font-medium text-slate-800 mt-1">{{ $quotation->event->event_date->format('M j, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Type</p>
                    <p class="text-sm font-medium text-slate-800 mt-1">{{ ucfirst($quotation->event->event_type) }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Guests</p>
                    <p class="text-sm font-medium text-slate-800 mt-1">{{ $quotation->event->guest_count }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Supplier</p>
                    <p class="text-sm font-medium text-slate-800 mt-1">{{ $quotation->supplier->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Sent date</p>
                    <p class="text-sm font-medium text-slate-800 mt-1">{{ $quotation->sent_at?->format('M j, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Total price</p>
                    <p class="text-sm font-medium text-slate-800 mt-1">${{ number_format($quotation->total_price, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Status</p>
                    <div class="mt-1"><x-status-badge :status="$quotation->status" /></div>
                </div>
                @if ($quotation->notes)
                    <div class="col-span-2">
                        <p class="text-xs text-slate-400">Note</p>
                        <p class="text-sm text-slate-600 bg-slate-50 rounded-lg px-3 py-2 mt-1">{{ $quotation->notes }}</p>
                    </div>
                @endif

                <div class="col-span-2 rounded-xl bg-slate-50 p-4 flex items-center gap-3">
                    <div class="h-9 w-9 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-semibold text-xs">
                        {{ strtoupper(substr($quotation->supplier->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 tracking-wide">SUPPLIER CONTACT</p>
                        <p class="text-sm font-medium text-slate-800">{{ $quotation->supplier->name }}</p>
                        <p class="text-xs text-slate-400">{{ $quotation->supplier->contact_email }} &middot; {{ $quotation->supplier->phone }}</p>
                    </div>
                </div>
            </div>
            
        </x-modal>
    @endforeach
</x-layouts.app>
