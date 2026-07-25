<x-layouts.supplier
    title="Payments"
    page-title="Payments"
    :page-subtitle="now()->format('l, F j, Y')">

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    @if($payments->isEmpty())

        <p class="px-6 py-12 text-center text-sm text-slate-400">
            No payments yet.
        </p>

    @else

    <table class="w-full text-sm">

        <thead>
            <tr class="bg-slate-50">
                <th class="px-6 py-3 text-left">PO Number</th>
                <th class="px-6 py-3 text-left">Customer</th>
                <th class="px-6 py-3 text-left">Event</th>
                <th class="px-6 py-3 text-left">Amount</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-right">Action</th>
            </tr>
        </thead>

        <tbody>

        @foreach($payments as $payment)

            <tr class="border-t">

                <td class="px-6 py-4">
                    {{ $payment->purchaseOrder->po_number }}
                </td>

                <td class="px-6 py-4">
                    {{ $payment->purchaseOrder->quotation->event->user->name }}
                </td>

                <td class="px-6 py-4">
                    {{ $payment->purchaseOrder->quotation->event->event_name }}
                </td>

                <td class="px-6 py-4">
                    ${{ number_format($payment->amount_paid, 2) }}
                </td>

                <td class="px-6 py-4">
                    <x-status-badge :status="$payment->payment_status" />
                </td>

                <td class="px-6 py-4 text-right">

                    <button
                        onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'payment-{{ $payment->id }}'}))"
                        class="text-brand-600 hover:text-brand-700 font-medium">

                        {{ $payment->payment_status === 'paid'
                            ? 'View Receipt'
                            : 'View Invoice' }}

                    </button>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

    @endif

</div>


{{-- Payment Modals --}}
@foreach($payments as $payment)

<x-modal :name="'payment-'.$payment->id" max-width="md">

    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">

        <h3 class="font-semibold text-slate-900">

            {{ $payment->payment_status === 'paid'
                ? 'Receipt'
                : 'Invoice' }}

        </h3>

        <button
            type="button"
            onclick="window.dispatchEvent(new CustomEvent('close-modal'))"
            class="text-slate-400 hover:text-slate-600">

            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>

            </svg>

        </button>

    </div>

    <div class="px-6 py-5 space-y-4">

        <div class="flex justify-between">
            <span class="text-slate-500">Invoice No</span>
            <span class="font-medium">{{ $payment->invoice_no }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-slate-500">PO Number</span>
            <span class="font-medium">{{ $payment->purchaseOrder->po_number }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-slate-500">Customer</span>
            <span class="font-medium">{{ $payment->purchaseOrder->quotation->event->user->name }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-slate-500">Event</span>
            <span class="font-medium">{{ $payment->purchaseOrder->quotation->event->event_name }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-slate-500">Amount</span>
            <span class="font-semibold text-brand-600">
                ${{ number_format($payment->amount_paid, 2) }}
            </span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-slate-500">Status</span>

            <x-status-badge :status="$payment->payment_status" />
        </div>

        @if($payment->payment_status === 'paid')

            <hr>

            <div class="flex justify-between">
                <span class="text-slate-500">Receipt No</span>
                <span class="font-medium">{{ $payment->receipt_no }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-slate-500">Paid At</span>
                <span class="font-medium">
                    {{ $payment->paid_at?->format('M j, Y g:i A') }}
                </span>
            </div>

        @else

            <div class="rounded-lg bg-amber-50 border border-amber-200 px-4 py-3 text-sm text-amber-700">

                Waiting for customer payment.

            </div>

        @endif

    </div>

    <div class="flex justify-end px-6 py-4 border-t border-slate-100">

        <button
            type="button"
            onclick="window.dispatchEvent(new CustomEvent('close-modal'))"
            class="rounded-lg border border-slate-200 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">

            Close

        </button>

    </div>

</x-modal>

@endforeach

</x-layouts.supplier>