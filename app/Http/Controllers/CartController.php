<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Event;
use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cartItems = CartItem::with(['menuItem.supplier', 'event'])
            ->where('user_id', Auth::id())
            ->whereNull('quotation_id')
            ->get()
            ->groupBy(fn (CartItem $item) => $item->event_id.'-'.$item->menuItem->supplier_id);

        return view('cart.index', compact('cartItems'));
    }

public function store(Request $request, MenuItem $menuItem): RedirectResponse
{
    $validated = $request->validate([
        'event_id' => ['required', 'exists:events,id'],
        'quantity' => ['required', 'integer', 'min:1'],
        'note' => ['nullable', 'string'],
    ]);

    $event = Event::findOrFail($validated['event_id']);
    abort_unless($event->user_id === Auth::id(), 403);

    $existing = CartItem::where('user_id', Auth::id())
        ->where('event_id', $event->id)
        ->where('menu_item_id', $menuItem->id)
        ->whereNull('quotation_id')
        ->first();

    if ($existing) {
        $newQuantity = $existing->quantity + $validated['quantity'];

        $existing->update([
            'quantity' => $newQuantity,
            'total_price' => $existing->unit_price * $newQuantity,
        ]);

        return back()->with('success', $menuItem->item_name.' quantity updated in cart.');
    }

    CartItem::create([
        'user_id' => Auth::id(),
        'event_id' => $event->id,
        'menu_item_id' => $menuItem->id,
        'quantity' => $validated['quantity'],
        'unit_price' => $menuItem->price,
        'total_price' => $menuItem->price * $validated['quantity'],
    ]);

    return back()->with('success', $menuItem->item_name.' added to cart.');
}

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        abort_unless($cartItem->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cartItem->update([
            'quantity' => $validated['quantity'],
            'total_price' => $cartItem->unit_price * $validated['quantity'],
        ]);

        return back()->with('success', 'Cart updated.');
    }

    public function destroy(CartItem $cartItem): RedirectResponse
    {
        abort_unless($cartItem->user_id === Auth::id(), 403);

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }
}
