<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SupplierController extends Controller
{
    /**
     * Browsing suppliers/menus. Open to users (customers).
     */
    public function index(Request $request): View
    {
        $query = Supplier::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->string('search').'%');
        }

        if ($request->filled('category') && $request->string('category') !== 'all') {
            $query->where('category', $request->string('category'));
        }

        $suppliers = $query->withCount('menuItems')->orderBy('name')->get();

        return view('suppliers.index', compact('suppliers'));
    }

    public function show(Supplier $supplier): View
    {
        $supplier->load('menuItems');

        $events = Event::where('user_id', Auth::id())
            ->whereNotIn('status', ['closed'])
            ->orderByDesc('event_date')
            ->get();

        return view('suppliers.show', compact('supplier', 'events'));
    }
}