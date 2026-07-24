<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $supplierId = Auth::user()->supplier_id;

        $purchaseOrders = PurchaseOrder::with([
            'quotation.event.user'
        ])
        ->whereHas('quotation', function ($query) use ($supplierId) {
            $query->where('supplier_id', $supplierId);
        })
        ->latest()
        ->get();

        return view('supplier.dashboard', compact('purchaseOrders'));
    }

    public function markDelivered(PurchaseOrder $purchaseOrder)
    {
        abort_unless(
            $purchaseOrder->quotation->supplier_id ==
            auth()->user()->supplier_id,
            403
        );

        $purchaseOrder->update([
            'delivery_status' => 'delivered',
            'delivered_at' => now(),
        ]);

        return back()->with(
            'success',
            'Order marked as delivered.'
        );
    }
}