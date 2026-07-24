<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Payment;
use App\Models\Quotation;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_events' => Event::count(),
            'total_quotations' => Quotation::count(),
            'accepted_quotations' => Quotation::where('status', 'accepted')->count(),
            'total_revenue' => Payment::where('payment_status', 'paid')->sum('amount_paid'),
        ];

        return view('admin.reports.index', compact('stats'));
    }
}