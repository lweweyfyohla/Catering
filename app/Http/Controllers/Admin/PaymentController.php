<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::with(['purchaseOrder.quotation.event.user', 'purchaseOrder.quotation.supplier'])
            ->latest()
            ->get();

        return view('admin.payments.index', compact('payments'));
    }
}