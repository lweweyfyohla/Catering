<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_suppliers' => User::where('role', 'supplier')->count(),
            'pending_quotations' => Quotation::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}