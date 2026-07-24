<x-layouts.app title="Suppliers - CaterSource Admin" page-title="Suppliers" :page-subtitle="now()->format('l, F j, Y')">

    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-slate-500">Create and manage supplier accounts</p>
        <button onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'new-supplier'}))"
                class="inline-flex items-center gap-2 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-4 py-2.5 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Supplier
        </button>
    </div>

    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search suppliers..."
               class="rounded-lg border-slate-200 text-sm w-64 focus:border-brand-400 focus:ring-brand-400">
        <select name="category" onchange="this.form.submit()" class="rounded-lg border-slate-200 text-sm focus:border-brand-400 focus:ring-brand-400">
            <option value="all">All categories</option>
            @foreach (['catering','beverage','dessert','other'] as $c)
                <option value="{{ $c }}" @selected(request('category') === $c)>{{ ucfirst($c) }}</option>
            @endforeach
        </select>
        <button class="rounded-lg border border-slate-200 text-slate-600 text-sm font-medium px-4 py-2 hover:bg-slate-50">Filter</button>
    </form>

    @if ($suppliers->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm px-6 py-12 text-center text-sm text-slate-400">
            No suppliers found. Add your first supplier to get started.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($suppliers as $supplier)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <a href="{{ route('suppliers.show', $supplier) }}" class="block hover:shadow-md transition">
                        <div class="h-28 bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center">
                            <span class="text-2xl font-bold text-brand-500">{{ strtoupper(substr($supplier->name, 0, 2)) }}</span>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-slate-900">{{ $supplier->name }}</h3>
                                <span class="text-xs font-medium text-amber-500 flex items-center gap-1">
                                    ★ {{ number_format($supplier->stars, 1) }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">{{ ucfirst($supplier->category) }} &middot; {{ $supplier->address ?? 'No address' }}</p>
                            <p class="text-xs text-slate-400 mt-2">{{ $supplier->menu_items_count }} menu items</p>
                        </div>
                    </a>
                    <div class="flex items-center justify-between px-5 pb-4 pt-2 border-t border-slate-100">
                        <button onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'edit-supplier-{{ $supplier->id }}'}))"
                                class="text-xs font-medium text-brand-600 hover:text-brand-700">Edit</button>
                        <form method="POST" action="{{ route('admin.suppliers.destroy', $supplier) }}" onsubmit="return confirm('Remove this supplier and its login?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-medium text-red-500 hover:text-red-600">Remove</button>
                        </form>
                    </div>
                </div>

                <x-modal name="edit-supplier-{{ $supplier->id }}" max-width="2xl">
                    <form method="POST" action="{{ route('admin.suppliers.update', $supplier) }}">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                            <h3 class="font-semibold text-slate-900">Edit {{ $supplier->name }}</h3>
                            <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))" class="text-slate-400 hover:text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <div class="px-6 py-5 grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Supplier name</label>
                                <input type="text" name="name" value="{{ $supplier->name }}" required class="w-full rounded-lg border-slate-200 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Category</label>
                                <select name="category" required class="w-full rounded-lg border-slate-200 text-sm">
                                    @foreach (['catering','beverage','dessert','other'] as $c)
                                        <option value="{{ $c }}" @selected($supplier->category === $c)>{{ ucfirst($c) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Login email</label>
                                <input type="email" name="contact_email" value="{{ $supplier->contact_email }}" class="w-full rounded-lg border-slate-200 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Address</label>
                                <input type="text" name="address" value="{{ $supplier->address }}" class="w-full rounded-lg border-slate-200 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Phone number</label>
                                <input type="text" name="phone" value="{{ $supplier->phone }}" class="w-full rounded-lg border-slate-200 text-sm">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
                                <textarea name="notes" rows="3" class="w-full rounded-lg border-slate-200 text-sm">{{ $supplier->notes }}</textarea>
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-100">
                            <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))"
                                    class="rounded-lg border border-slate-200 text-slate-600 text-sm font-medium px-4 py-2 hover:bg-slate-50">Cancel</button>
                            <button type="submit" class="rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-4 py-2">Save Changes</button>
                        </div>
                    </form>
                </x-modal>
            @endforeach
        </div>
    @endif

    <x-modal name="new-supplier" max-width="2xl">
        <form method="POST" action="{{ route('admin.suppliers.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-900">New Supplier</h3>
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-6 py-5 grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Supplier name</label>
                    <input type="text" name="name" required placeholder="e.g. KOI Cambodia" class="w-full rounded-lg border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Supplier Logo</label>
                    <input type="file" name="logo" accept="image/*" class="w-full text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Cover image</label>
                    <input type="file" name="image_cover" accept="image/*" class="w-full text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Supplier Category</label>
                    <select name="category" required class="w-full rounded-lg border-slate-200 text-sm">
                        <option value="catering">Catering</option>
                        <option value="beverage">Beverage</option>
                        <option value="dessert">Dessert</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Address</label>
                    <input type="text" name="address" class="w-full rounded-lg border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Login email <span class="text-red-400">*</span></label>
                    <input type="email" name="contact_email" required class="w-full rounded-lg border-slate-200 text-sm">
                    <p class="text-xs text-slate-400 mt-1">This is also the supplier's sign-in email.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Phone number</label>
                    <input type="text" name="phone" class="w-full rounded-lg border-slate-200 text-sm">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Login password <span class="text-red-400">*</span></label>
                    <input type="password" name="password" required minlength="8" class="w-full rounded-lg border-slate-200 text-sm">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Supplier Description</label>
                    <textarea name="notes" rows="4" class="w-full rounded-lg border-slate-200 text-sm"></textarea>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-100">
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))"
                        class="rounded-lg border border-slate-200 text-slate-600 text-sm font-medium px-4 py-2 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-4 py-2">Add Supplier</button>
            </div>
        </form>
    </x-modal>
</x-layouts.app>