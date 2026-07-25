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
                    ${{ number_format($payment->amount_paid,2) }}
                </td>

                <td class="px-6 py-4">
                    <x-status-badge :status="$payment->payment_status" />
                </td>

                <td class="px-6 py-4 text-right">

                    <button
                        class="text-brand-600 hover:text-brand-700">

                        View

                    </button>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

    @endif

</div>

</x-layouts.supplier>