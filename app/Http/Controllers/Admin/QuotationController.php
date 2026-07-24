<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use Illuminate\View\View;

class QuotationController extends Controller
{
    public function index(): View
    {
        $quotations = Quotation::with(['event.user', 'supplier'])
            ->latest('sent_at')
            ->get();

        return view('admin.quotations.index', compact('quotations'));
    }
}