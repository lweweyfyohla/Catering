<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    public function index(): View
    {
        $supplier = Auth::user()->supplier;
        abort_unless($supplier, 403);

        $menuItems = $supplier->menuItems()->orderBy('item_name')->get();

        return view('supplier.menu-items.index', compact('menuItems'));
    }

    public function store(Request $request): RedirectResponse
    {
        $supplier = Auth::user()->supplier;
        abort_unless($supplier, 403);

        $validated = $request->validate([
            'item_name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('menu-items', 'public');
        }

       $menuItem = $supplier->menuItems()
    ->where('item_name', $validated['item_name'])
    ->first();

if ($menuItem) {
    $menuItem->update($validated);
    return back()->with('success', 'Menu item already existed — updated instead of duplicating.');
}

$supplier->menuItems()->create($validated);

return back()->with('success', 'Menu item added.');
    }

    public function update(Request $request, MenuItem $menuItem): RedirectResponse
    {
        abort_unless($menuItem->supplier_id === Auth::user()->supplier_id, 403);

        $validated = $request->validate([
            'item_name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $menuItem->update($validated);

        return back()->with('success', 'Menu item updated.');
    }

    public function destroy(MenuItem $menuItem): RedirectResponse
    {
        abort_unless($menuItem->supplier_id === Auth::user()->supplier_id, 403);

        $menuItem->delete();

        return back()->with('success', 'Menu item removed.');
    }
}