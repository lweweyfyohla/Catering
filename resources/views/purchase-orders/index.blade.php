<x-layouts.app title="Purchase Orders - CaterSource" page-title="Purchase Orders" :page-subtitle="now()->format('l, F j, Y')">

    <p class="text-sm text-slate-500 mb-6">
        Track your purchase orders and confirm delivery once your order arrives.
    </p>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

        @if ($purchaseOrders->isEmpty())

            <p class="px-6 py-12 text-center text-sm text-slate-400">
                No purchase orders yet.
            </p>

        @else

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead>
                        <tr class="text-left text-slate-400 text-xs uppercase tracking-wide bg-slate-50">
                            <th class="px-6 py-3 font-medium">PO Number</th>
                            <th class="px-6 py-3 font-medium">Event</th>
                            <th class="px-6 py-3 font-medium">Supplier</th>
                            <th class="px-6 py-3 font-medium">Amount</th>
                            <th class="px-6 py-3 font-medium">Delivery</th>
                            <th class="px-6 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-50">

                        @foreach ($purchaseOrders as $po)

                            <tr>

                                <td class="px-6 py-4 font-medium text-slate-800">
                                    {{ $po->po_number }}
                                </td>

                                <td class="px-6 py-4 text-slate-500">
                                    {{ $po->quotation->event->event_name }}
                                </td>

                                <td class="px-6 py-4 text-slate-500">
                                    {{ $po->quotation->supplier->name }}
                                </td>

                                <td class="px-6 py-4 text-slate-500">
                                    ${{ number_format($po->total_price, 2) }}
                                </td>

                                <td class="px-6 py-4">
                                    <x-status-badge :status="$po->delivery_status" />
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">

                                        <button
                                            onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'po-{{ $po->id }}'}))"
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-brand-600 hover:bg-brand-50">

                                            <svg class="w-4 h-4"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z"/>
                                                <circle cx="12"
                                                        cy="12"
                                                        r="3"
                                                        stroke-width="2"/>
                                            </svg>

                                        </button>

                                    </div>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </div>

    @foreach ($purchaseOrders as $po)

        <x-modal :name="'po-'.$po->id" max-width="md">

            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">

                <h3 class="font-semibold text-slate-900">
                    {{ $po->po_number }}
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

            <div class="px-6 py-5 grid grid-cols-2 gap-4">

                <div>
                    <p class="text-xs text-slate-400">Event</p>
                    <p class="text-sm font-medium text-slate-800 mt-1">
                        {{ $po->quotation->event->event_name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-400">Supplier</p>
                    <p class="text-sm font-medium text-slate-800 mt-1">
                        {{ $po->quotation->supplier->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-400">Amount</p>
                    <p class="text-sm font-medium text-slate-800 mt-1">
                        ${{ number_format($po->total_price, 2) }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-400">Issued</p>
                    <p class="text-sm font-medium text-slate-800 mt-1">
                        {{ $po->issued_at?->format('M j, Y') }}
                    </p>
                </div>

                <div class="col-span-2">
                    <p class="text-xs text-slate-400">Delivery Status</p>

                    <div class="mt-1">
                        <x-status-badge :status="$po->delivery_status" />
                    </div>
                </div>

            </div>

            <div class="px-6 pb-5 border-t border-slate-100 pt-4 space-y-3">

                @if ($po->delivery_status === 'completed')

                        <div class="w-full rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-center py-2 text-sm font-medium">
                            ✓ Delivery Confirmed
                        </div>

                    @elseif ($po->delivery_status === 'delivered')

                        <form method="POST"
                            action="{{ route('purchase-orders.confirm-delivery', $po) }}">
                            @csrf

                            <button
                                type="submit"
                                class="w-full rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium py-2">
                                Confirm Delivery
                            </button>
                        </form>

                    @else

                        <div class="w-full rounded-lg bg-slate-100 text-slate-500 text-center py-2 text-sm">
                            Waiting for supplier to deliver
                        </div>

                    @endif

                <form method="POST"
                      action="{{ route('purchase-orders.upload-invoice', $po) }}"
                      enctype="multipart/form-data"
                      class="pt-2 border-t border-slate-100">

                    @csrf

                    <p class="text-xs font-medium text-slate-500 mb-2">
                        Upload invoice
                    </p>

                    <div class="flex gap-2">

                        <input
                            type="text"
                            name="invoice_no"
                            placeholder="Invoice number"
                            required
                            class="flex-1 rounded-lg border-slate-200 text-sm">

                        <input
                            type="file"
                            name="invoice_file"
                            class="flex-1 text-xs">

                    </div>

                    <button
                        type="submit"
                        class="mt-2 w-full rounded-lg border border-slate-200 text-slate-600 text-sm font-medium py-2 hover:bg-slate-50">

                        Save Invoice

                    </button>

                </form>

            </div>

            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-100">

                <button
                    type="button"
                    onclick="window.dispatchEvent(new CustomEvent('close-modal'))"
                    class="rounded-lg border border-slate-200 text-slate-600 text-sm font-medium px-4 py-2 hover:bg-slate-50">

                    Close

                </button>

            </div>

        </x-modal>

    @endforeach

</x-layouts.app>