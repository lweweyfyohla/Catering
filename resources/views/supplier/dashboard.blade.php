<x-layouts.supplier
    title="Supplier Dashboard"
    page-title="Supplier Dashboard"
    :page-subtitle="now()->format('l, F j, Y')">

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    @if($purchaseOrders->isEmpty())

        <p class="px-6 py-12 text-center text-sm text-slate-400">
            No confirmed orders yet.
        </p>

    @else

        <table class="w-full text-sm">

            <thead>
                <tr class="bg-slate-50">
                    <th class="px-6 py-3 text-left">PO Number</th>
                    <th class="px-6 py-3 text-left">Event</th>
                    <th class="px-6 py-3 text-left">Customer</th>
                    <th class="px-6 py-3 text-left">Total</th>
                    <th class="px-6 py-3 text-left">Delivery</th>
                    <th class="px-6 py-3 text-left">Payment</th>
                    <th class="px-6 py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody>

            @foreach($purchaseOrders as $po)

                <tr class="border-t">

                    <td class="px-6 py-4 font-medium">
                        {{ $po->po_number }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $po->quotation->event->event_name }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $po->quotation->event->user->name }}
                    </td>

                    <td class="px-6 py-4">
                        ${{ number_format($po->total_price, 2) }}
                    </td>

                    <td class="px-6 py-4">
                        <x-status-badge :status="$po->delivery_status" />
                    </td>

                    <td class="px-6 py-4">
                        <x-status-badge :status="$po->payment?->payment_status ?? 'pending'" />
                    </td>

                    <td class="px-6 py-4 text-right">

                        @if($po->delivery_status == 'pending')

                            <form method="POST"
                                action="{{ route('supplier.dashboard.delivered', $po) }}">
                                @csrf
                                @method('PATCH')

                                <button
                                    class="bg-brand-600 hover:bg-brand-700 text-white rounded-lg px-3 py-2 text-sm">
                                    Mark Delivered
                                </button>
                            </form>

                        @elseif($po->payment?->payment_status === 'paid')

                            <span class="text-green-600 font-medium">
                                Delivered & Paid
                            </span>

                        @else

                            <span class="text-amber-600 font-medium">
                                Delivered
                            </span>

                        @endif

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    @endif

</div>

</x-layouts.supplier>