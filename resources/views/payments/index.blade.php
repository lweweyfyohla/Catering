<x-layouts.app title="Delivery & Payment - CaterSource" page-title="Delivery & Payment" :page-subtitle="'Confirm deliveries, log invoices, and process payments'">

    <h2 class="font-semibold text-slate-900 mb-4">Payments</h2>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        @if ($payments->isEmpty())
            <p class="px-6 py-12 text-center text-sm text-slate-400">No payment records yet. Upload an invoice on a purchase order to create one.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-slate-400 text-xs uppercase tracking-wide bg-slate-50">
                            <th class="px-6 py-3 font-medium">PO Number</th>
                            <th class="px-6 py-3 font-medium">Event</th>
                            <th class="px-6 py-3 font-medium">Supplier</th>
                            <th class="px-6 py-3 font-medium">Amount</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($payments as $payment)
                            @php $po = $payment->purchaseOrder; @endphp
                            <tr>
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $po->po_number }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $po->quotation->event->event_name }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $po->quotation->supplier->name }}</td>
                                <td class="px-6 py-4 text-slate-500">${{ number_format($payment->amount_paid, 2) }}</td>
                                <td class="px-6 py-4"><x-status-badge :status="$payment->payment_status" /></td>
                                <td class="px-6 py-4 text-right">
                                    <button onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'pay-{{ $payment->id }}'}))"
                                            class="inline-flex items-center gap-1 rounded-lg bg-brand-50 text-brand-600 text-xs font-medium px-3 py-1.5 hover:bg-brand-100">
                                        {{ $payment->payment_status === 'paid' ? 'View receipt' : 'Pay Invoice' }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @foreach ($payments as $payment)
        @php $po = $payment->purchaseOrder; @endphp
        <x-modal :name="'pay-'.$payment->id" max-width="sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-900">{{ $payment->payment_status === 'paid' ? 'Receipt' : 'Pay Invoice' }}</h3>
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-6 py-5 space-y-3">
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-xs text-slate-400">PO number</p>
                        <p class="font-medium text-slate-800">{{ $po->po_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Event</p>
                        <p class="font-medium text-slate-800">{{ $po->quotation->event->event_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Supplier</p>
                        <p class="font-medium text-slate-800">{{ $po->quotation->supplier->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Due date</p>
                        <p class="font-medium text-slate-800">{{ $po->invoice_date?->format('M j, Y') ?? '—' }}</p>
                    </div>
                </div>
                <div class="rounded-lg bg-slate-50 px-4 py-3 flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-700">Total</span>
                    <span class="text-brand-600 font-bold">${{ number_format($payment->amount_paid, 2) }}</span>
                </div>

                @if ($payment->payment_status === 'paid')
                    <div class="rounded-lg bg-emerald-50 text-emerald-700 text-sm px-4 py-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Payment complete &middot; Receipt {{ $payment->receipt_no }}
                    </div>
                @else
                    <form method="POST" action="{{ route('payments.pay', $payment) }}" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Receipt number</label>
                            <input type="text" name="receipt_no" required placeholder="e.g. INV-2026-0389" class="w-full rounded-lg border-slate-200 text-sm">
                        </div>
                        <button type="submit" class="w-full rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium py-2.5">Mark as paid</button>
                    </form>
                @endif
            </div>
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-100">
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))"
                        class="rounded-lg border border-slate-200 text-slate-600 text-sm font-medium px-4 py-2 hover:bg-slate-50">Close</button>
            </div>
        </x-modal>
    @endforeach
</x-layouts.app>
