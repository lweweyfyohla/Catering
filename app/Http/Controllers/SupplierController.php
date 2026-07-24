<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SupplierController extends Controller
{
    /**
     * Browsing suppliers/menus. Open to users (customers) and admins.
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

    /**
     * Admin-only: creates the Supplier record AND the linked supplier-role
     * User account (login) in one step. Menu items are managed by the
     * supplier themselves, never here.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category' => ['required', 'in:catering,beverage,dessert,other'],
            'contact_email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'image_cover' => ['nullable', 'image', 'max:4096'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('suppliers/logos', 'public');
        }

        if ($request->hasFile('image_cover')) {
            $validated['image_cover'] = $request->file('image_cover')->store('suppliers/covers', 'public');
        }

        $validated['registered_at'] = now();
        $validated['stars'] = 5;

        $supplierAttributes = collect($validated)->except('password')->toArray();

        $supplier = Supplier::create($supplierAttributes);

        User::create([
            'name' => $supplier->name,
            'email' => $supplier->contact_email,
            'password' => Hash::make($validated['password']),
            'role' => 'supplier',
            'supplier_id' => $supplier->id,
        ]);

        return back()->with('success', 'Supplier added and login created.');
    }

    /**
     * Admin-only: edits the Supplier's own profile fields. Never touches
     * menu items — that stays with the supplier.
     */
    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category' => ['required', 'in:catering,beverage,dessert,other'],
            'contact_email' => [
                'nullable', 'email', 'max:150',
                Rule::unique('users', 'email')->ignore($supplier->user?->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $supplier->update($validated);

        // Keep the linked login's email in sync if it changed.
        if ($supplier->user && $validated['contact_email'] ?? null) {
            $supplier->user->update(['email' => $validated['contact_email']]);
        }

        return back()->with('success', 'Supplier updated.');
    }

    /**
     * Admin-only: removes the supplier and its linked login together so we
     * never leave an orphaned supplier-role User with no supplier_id.
     */
    public function destroy(Supplier $supplier): RedirectResponse
    {
        $supplier->user?->delete();
        $supplier->delete();

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier removed.');
    }
}