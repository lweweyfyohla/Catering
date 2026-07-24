<x-layouts.supplier
    title="Quotation Requests"
    page-title="Quotation Requests"
    :page-subtitle="now()->format('l, F j, Y')">

<div class="space-y-6">

    @forelse($quotations as $quotation)

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div>
                    <h2 class="font-semibold text-slate-900">
                        Quotation #{{ $quotation->id }}
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        <strong>Event:</strong>
                        {{ $quotation->event->event_name }}
                    </p>

                    <p class="text-sm text-slate-500">
                        <strong>Customer:</strong>
                        {{ $quotation->event->user->name }}
                    </p>

                    <p class="text-sm text-slate-500">
                        Event Date:
                        <span class="font-medium text-slate-800">
                            {{ $quotation->event->event_date->format('M d, Y') }}
                        </span>
                    </p>
                </div>

                <x-status-badge :status="$quotation->status" />
            </div>

            <!-- Requested Items -->
            <div class="px-6 py-5">

                <h3 class="font-medium text-slate-800 mb-3">
                    Requested Items
                </h3>

                <table class="w-full text-sm border border-slate-200 rounded-lg overflow-hidden">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="text-left px-4 py-2">Item</th>
                            <th class="text-center px-4 py-2">Qty</th>
                            <th class="text-right px-4 py-2">Unit Price</th>
                            <th class="text-right px-4 py-2">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($quotation->cartItems as $item)

                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3">
                                {{ $item->menuItem->item_name }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->quantity }}
                            </td>

                            <td class="px-4 py-3 text-right">
                                ${{ number_format($item->unit_price, 2) }}
                            </td>

                            <td class="px-4 py-3 text-right font-medium">
                                ${{ number_format($item->total_price, 2) }}
                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>

                @if($quotation->notes)
                    <div class="mt-4 rounded-lg bg-amber-50 border border-amber-100 p-4">
                        <p class="text-sm font-medium text-amber-700">
                            Customer Note
                        </p>

                        <p class="text-sm text-amber-700 mt-1">
                            {{ $quotation->notes }}
                        </p>
                    </div>
                @endif

                <div class="mt-5 flex items-center justify-between">
                    <span class="text-lg font-semibold text-slate-900">
                        Total
                    </span>

                    <span class="text-xl font-bold text-brand-600">
                        ${{ number_format($quotation->total_price, 2) }}
                    </span>
                </div>

            </div>

            <!-- Footer -->
            @if($quotation->status === 'pending')

                <div class="flex justify-end gap-3 px-6 py-4 border-t border-slate-100">

                    <form method="POST"
                          action="{{ route('supplier.quotations.update-status', $quotation) }}">
                        @csrf
                        @method('PATCH')

                        <input type="hidden"
                               name="status"
                               value="rejected">

                        <button
                            class="px-5 py-2 rounded-lg border border-red-300 text-red-600 hover:bg-red-50">
                            Reject
                        </button>

                    </form>

                    <form method="POST"
                          action="{{ route('supplier.quotations.update-status', $quotation) }}">
                        @csrf
                        @method('PATCH')

                        <input type="hidden"
                               name="status"
                               value="accepted">

                        <button
                            class="px-5 py-2 rounded-lg bg-brand-500 text-white hover:bg-brand-600">
                            Accept Quote
                        </button>

                    </form>

                </div>

            @endif

        </div>

    @empty

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm px-6 py-12 text-center">
            <p class="text-slate-400">
                No quotation requests received.
            </p>
        </div>

    @endforelse

</div>

</x-layouts.supplier>