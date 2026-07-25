<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_customers' => User::where('role', 'user')->count(),
            'total_suppliers' => Supplier::count(),
            'total_quotations' => Quotation::count(),
            'total_purchase_orders' => PurchaseOrder::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}