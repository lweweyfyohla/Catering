<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PurchaseOrderController extends Controller
{
    public function index(): View
    {
        $purchaseOrders = PurchaseOrder::with(['quotation.event', 'quotation.supplier'])
            ->whereHas('quotation.event', fn ($q) => $q->where('user_id', Auth::id()))
            ->latest('issued_at')
            ->get();

        return view('purchase-orders.index', compact('purchaseOrders'));
    }

    public function confirm(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->authorizeOwner($purchaseOrder);

        $purchaseOrder->update(['status' => 'confirmed']);

        return back()->with('success', 'Purchase order confirmed.');
    }

    public function cancel(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->authorizeOwner($purchaseOrder);

        abort_unless($purchaseOrder->status === 'issued', 422, 'Only unconfirmed orders can be cancelled.');

        $purchaseOrder->update(['status' => 'cancelled']);

        return back()->with('success', 'Purchase order cancelled.');
    }

    public function confirmDelivery(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->authorizeOwner($purchaseOrder);

        $purchaseOrder->update([
            'delivery_status' => 'delivered',
            'delivered_at' => now(),
            'goods_verified' => true,
        ]);

        $purchaseOrder->quotation->event->update(['status' => 'delivered']);

        return back()->with('success', 'Delivery confirmed.');
    }

    public function uploadInvoice(Request $request, PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->authorizeOwner($purchaseOrder);

        $validated = $request->validate([
            'invoice_no' => ['required', 'string', 'max:100'],
            'invoice_file' => ['nullable', 'file', 'max:8192'],
        ]);

        if ($request->hasFile('invoice_file')) {
            $validated['invoice_file'] = $request->file('invoice_file')->store('invoices', 'public');
        }

        $validated['invoice_date'] = now();

        $purchaseOrder->update($validated);

        $purchaseOrder->payment()->firstOrCreate([], [
            'amount_paid' => $purchaseOrder->total_price,
            'payment_status' => 'pending',
        ]);

        return back()->with('success', 'Invoice details saved.');
    }

    private function authorizeOwner(PurchaseOrder $purchaseOrder): void
    {
        abort_unless($purchaseOrder->quotation->event->user_id === Auth::id(), 403);
    }
}
