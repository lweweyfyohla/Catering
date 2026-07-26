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

        if ($request->filled('category') && $request->string('category') !== 'all') {
            $query->where('category', $request->string('category'));
        }

        $suppliers = $query->withCount('menuItems')->orderBy('name')->get();

        if ($request->filled('event_id')) {
            session(['sourcing_event_id' => $request->integer('event_id')]);
        }

        $events = Event::where('user_id', Auth::id())->whereNotIn('status', ['closed'])->orderByDesc('event_date')->get();
        $selectedEvent = $events->firstWhere('id', session('sourcing_event_id'));

        return view('suppliers.index', compact('suppliers', 'events', 'selectedEvent'));
    }

    public function show(Request $request, Supplier $supplier): View
    {
        $supplier->load('menuItems');

        if ($request->filled('event_id')) {
            session(['sourcing_event_id' => $request->integer('event_id')]);
        }

        $events = Event::where('user_id', Auth::id())->whereNotIn('status', ['closed'])->orderByDesc('event_date')->get();
        $selectedEvent = $events->firstWhere('id', session('sourcing_event_id'));

        return view('suppliers.show', compact('supplier', 'events', 'selectedEvent'));
    }
}