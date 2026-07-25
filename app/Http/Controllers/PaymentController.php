<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::with(['purchaseOrder.quotation.event', 'purchaseOrder.quotation.supplier'])
            ->whereHas('purchaseOrder.quotation.event', fn ($q) => $q->where('user_id', Auth::id()))
            ->latest()
            ->get();

        return view('payments.index', compact('payments'));
    }

    public function pay(Payment $payment): RedirectResponse
    {
        abort_unless(
            $payment->purchaseOrder->quotation->event->user_id === Auth::id(),
            403
        );

        $payment->update([
            'payment_status' => 'paid',
            'receipt_no' => 'RCPT-' . now()->format('Y') . '-' . str_pad($payment->id, 4, '0', STR_PAD_LEFT),
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Payment completed successfully.');
    }
}
