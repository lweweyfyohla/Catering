<x-layouts.supplier title="Quote Requests - CaterSource Supplier Portal" page-title="Quote Requests" :page-subtitle="now()->format('l, F j, Y')">

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        @if ($quotations->isEmpty())
            <p class="px-6 py-12 text-center text-sm text-slate-400">No quote requests yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-slate-400 text-xs uppercase tracking-wide bg-slate-50">
                            <th class="px-6 py-3 font-medium">Event</th>
                            <th class="px-6 py-3 font-medium">Customer</th>
                            <th class="px-6 py-3 font-medium">Sent Date</th>
                            <th class="px-6 py-3 font-medium">Total</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($quotations as $quotation)
                            <tr>
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $quotation->event->event_name }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $quotation->event->user->name }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $quotation->sent_at?->format('M j, Y') }}</td>
                                <td class="px-6 py-4 text-slate-700 font-medium">${{ number_format($quotation->total_price, 2) }}</td>
                                <td class="px-6 py-4"><x-status-badge :status="$quotation->status" /></td>
                                <td class="px-6 py-4 text-right">
                                    @if ($quotation->status === 'pending')
                                        <button onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'req-{{ $quotation->id }}'}))"
                                                class="rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-xs font-medium px-3 py-1.5">
                                            Review
                                        </button>
                                    @else
                                        <span class="text-xs text-slate-300">&mdash;</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @foreach ($quotations->where('status', 'pending') as $quotation)
        <x-modal :name="'req-'.$quotation->id" max-width="md">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-900">Quote request</h3>
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
                    <p class="text-xs text-slate-400">Customer</p>
                    <p class="text-sm font-medium text-slate-800 mt-1">{{ $quotation->event->user->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Guests</p>
                    <p class="text-sm font-medium text-slate-800 mt-1">{{ $quotation->event->guest_count }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-slate-400">Total price</p>
                    <p class="text-lg font-bold text-brand-600 mt-1">${{ number_format($quotation->total_price, 2) }}</p>
                </div>
                @if ($quotation->notes)
                    <div class="col-span-2">
                        <p class="text-xs text-slate-400">Note from customer</p>
                        <p class="text-sm text-slate-600 bg-slate-50 rounded-lg px-3 py-2 mt-1">{{ $quotation->notes }}</p>
                    </div>
                @endif
            </div>
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-100">
                <form method="POST" action="{{ route('supplier.quotations.update-status', $quotation) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="cancel">
                    <button type="submit" class="rounded-lg border border-red-200 text-red-500 text-sm font-medium px-4 py-2 hover:bg-red-50">Reject</button>
                </form>
                <form method="POST" action="{{ route('supplier.quotations.update-status', $quotation) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="accepted">
                    <button type="submit" class="rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-4 py-2">Confirm quote</button>
                </form>
            </div>
        </x-modal>
    @endforeach
</x-layouts.supplier>
