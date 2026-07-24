<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\View\View;

class PurchaseOrderController extends Controller
{
    public function index(): View
    {
        $purchaseOrders = PurchaseOrder::with(['quotation.event.user', 'quotation.supplier'])
            ->latest('issued_at')
            ->get();

        return view('admin.purchase-orders.index', compact('purchaseOrders'));
    }
}