<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $supplierId = Auth::user()->supplier_id;

        $payments = Payment::with([
            'purchaseOrder.quotation.event.user',
            'purchaseOrder.quotation.supplier',
        ])
        ->whereHas('purchaseOrder.quotation', function ($query) use ($supplierId) {
            $query->where('supplier_id', $supplierId);
        })
        ->latest()
        ->get();

        return view('supplier.payments.index', compact('payments'));
    }
}