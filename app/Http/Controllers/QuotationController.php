<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Event;
use App\Models\Quotation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class QuotationController extends Controller
{
    public function index(): View
    {
        $quotations = Quotation::with(['event', 'supplier'])
            ->whereHas('event', fn ($q) => $q->where('user_id', Auth::id()))
            ->latest('sent_at')
            ->get();

        $compareEvents = Event::query()
            ->where('user_id', Auth::id())
            ->whereHas('cartItems', fn ($q) => $q->whereNull('quotation_id'))
            ->withCount(['cartItems' => fn ($q) => $q->whereNull('quotation_id')])
            ->latest()
            ->get();

        return view('quotations.index', compact('quotations', 'compareEvents'));
    }

    public function compare(Event $event): View
    {
        abort_unless($event->user_id === Auth::id(), 403);

        $estimates = CartItem::query()
            ->join('menu_items', 'cart_items.menu_item_id', '=', 'menu_items.id')
            ->join('suppliers', 'menu_items.supplier_id', '=', 'suppliers.id')
            ->where('cart_items.event_id', $event->id)
            ->whereNull('cart_items.quotation_id')
            ->select(
                'suppliers.id as supplier_id',
                'suppliers.name as supplier_name',
                DB::raw('SUM(cart_items.quantity * cart_items.unit_price) as estimated_total'),
                DB::raw('COUNT(cart_items.id) as item_count')
            )
            ->groupBy('suppliers.id', 'suppliers.name')
            ->orderBy('estimated_total')
            ->get();

        return view('quotations.compare', compact('event', 'estimates'));
    }

    public function store(Request $request, Event $event): RedirectResponse
    {
        abort_unless($event->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'notes' => ['nullable', 'string'],
        ]);

        $cartItems = CartItem::whereNull('quotation_id')
            ->where('event_id', $event->id)
            ->whereHas('menuItem', fn ($q) => $q->where('supplier_id', $validated['supplier_id']))
            ->get();

        abort_if($cartItems->isEmpty(), 422, 'No items in cart for this supplier.');

        $total = $cartItems->sum('total_price');

        $quotation = Quotation::create([
            'event_id' => $event->id,
            'supplier_id' => $validated['supplier_id'],
            'status' => 'pending',
            'total_price' => $total,
            'notes' => $validated['notes'] ?? null,
            'sent_at' => now(),
        ]);

        CartItem::whereIn('id', $cartItems->pluck('id'))->update(['quotation_id' => $quotation->id]);

        $event->update(['status' => 'sourcing']);

        return redirect()->route('quotations.index')->with('success', 'Quote request sent to supplier.');
    }

    /**
     * Customer-side action: the event owner can only withdraw a request while
     * it's still pending. Accepting a quote is now done by the supplier
     * themselves, from the supplier portal (see Supplier\QuotationController).
     */
    public function updateStatus(Request $request, Quotation $quotation): RedirectResponse
    {
        abort_unless($quotation->event->user_id === Auth::id(), 403);
        abort_unless($quotation->status === 'pending', 422, 'This quote request has already been resolved.');

        $request->validate([
            'status' => ['required', 'in:cancel'],
        ]);

        $quotation->update(['status' => 'cancel']);

        return back()->with('success', 'Quote request withdrawn.');
    }
}
