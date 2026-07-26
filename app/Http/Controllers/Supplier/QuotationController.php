<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Payment;

class QuotationController extends Controller
{
    public function index(): View
    {
        $supplierId = Auth::user()->supplier_id;

        $quotations = Quotation::with([
            'event.user',
            'cartItems.menuItem'
        ])
            ->where('supplier_id', $supplierId)
            ->where('status', 'pending')
            ->latest('sent_at')
            ->get();

        return view('supplier.quotations.index', compact('quotations'));
    }

    public function updateStatus(Request $request, Quotation $quotation): RedirectResponse
    {
        abort_unless($quotation->supplier_id === Auth::user()->supplier_id, 403);
        if ($quotation->status !== 'pending') {
            return back()->with('error', 'This quote request has already been resolved.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:accepted,rejected'],
        ]);

        $quotation->update([
            'status' => $validated['status'],
        ]);

        if ($validated['status'] === 'accepted') {
            $purchaseOrder = PurchaseOrder::create([
                'quotation_id' => $quotation->id,
                'po_number' => 'PO-' . now()->format('Y') . '-' . str_pad((string) ($quotation->id * 111), 4, '0', STR_PAD_LEFT),
                'total_price' => $quotation->total_price,
                'status' => 'issued',
                'delivery_status' => 'pending',
                'issued_at' => now(),
            ]);
            
            Payment::create([
                'purchase_order_id' => $purchaseOrder->id,
                'amount_paid' => $purchaseOrder->total_price,
                'payment_status' => 'unpaid',
            ]);

            $quotation->event->update([
                'status' => 'ordered',
            ]);

            return back()->with('success', 'Quote confirmed. The order has been sent to Purchase Orders.');
        }

        return back()->with('success', 'Quote request rejected.');
    }
}