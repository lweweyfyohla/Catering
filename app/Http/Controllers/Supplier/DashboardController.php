<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $supplierId = Auth::user()->supplier_id;

        $purchaseOrders = PurchaseOrder::with([
            'quotation.event',
            'quotation.event.user',
            'payment',
        ])
        ->whereHas('quotation', function ($query) use ($supplierId) {
            $query->where('supplier_id', $supplierId);
        })
        ->latest()
        ->get();

        $stats = [
            'total_orders' => $purchaseOrders->count(),

            'pending_delivery' => $purchaseOrders
                ->where('delivery_status', 'pending')
                ->count(),

            'completed_delivery' => $purchaseOrders
                ->where('delivery_status', 'delivered')
                ->count(),

            'unpaid' => Payment::whereHas('purchaseOrder.quotation', function ($query) use ($supplierId) {
                $query->where('supplier_id', $supplierId);
            })
            ->where('payment_status', 'unpaid')
            ->count(),
        ];

        return view('supplier.dashboard', compact(
            'purchaseOrders',
            'stats'
        ));
    }

    public function markDelivered(PurchaseOrder $purchaseOrder)
    {
        abort_unless(
            $purchaseOrder->quotation->supplier_id === Auth::user()->supplier_id,
            403
        );

        $purchaseOrder->update([
            'delivery_status' => 'delivered',
        ]);

        $purchaseOrder->quotation->event->update([
            'status' => 'delivered',
        ]);

        return back()->with(
            'success',
            'Delivery marked as completed.'
        );
    }
}