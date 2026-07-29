<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PurchaseOrderController extends Controller
{
    public function index(): View
    {
        $purchaseOrders = PurchaseOrder::with([
            'quotation.event',
            'quotation.supplier',
            'payment'
        ])
        ->whereHas('quotation.event', fn ($q) => $q->where('user_id', Auth::id()))
        ->latest('issued_at')
        ->get();

        return view('purchase-orders.index', compact('purchaseOrders'));
    }

    public function confirm(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->authorizeOwner($purchaseOrder);

        $purchaseOrder->update([
            'status' => 'confirmed',
        ]);

        return back()->with('success', 'Purchase order confirmed.');
    }

    public function cancel(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->authorizeOwner($purchaseOrder);

        abort_unless(
            $purchaseOrder->status === 'issued',
            422,
            'Only unconfirmed orders can be cancelled.'
        );

        $purchaseOrder->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Purchase order cancelled.');
    }

    public function confirmDelivery(PurchaseOrder $purchaseOrder): RedirectResponse
    {
        $this->authorizeOwner($purchaseOrder);

        $purchaseOrder->update([
            'delivery_status' => 'completed',
        ]);

        return back()->with('success', 'Delivery confirmed successfully.');
    }

    private function authorizeOwner(PurchaseOrder $purchaseOrder): void
    {
        abort_unless(
            $purchaseOrder->quotation->event->user_id === Auth::id(),
            403
        );
    }
}