<x-layouts.app title="Suppliers - CaterSource Admin" page-title="Manage Suppliers" :page-subtitle="now()->format('l, F j, Y')">

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
        <button class="rounded-lg border border-slate-200 text-slate-600 text-sm font-medium px-4 py-2 hover:bg-slate-50">Search</button>
        @if (request('search'))
            <a href="{{ route('admin.suppliers.index') }}" class="rounded-lg text-slate-400 text-sm font-medium px-4 py-2 hover:text-slate-600">Clear</a>
        @endif
    </form>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        @if ($suppliers->isEmpty())
            <p class="px-6 py-12 text-center text-sm text-slate-400">No suppliers found. Add your first supplier to get started.</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-6 py-3 text-left">Supplier</th>
                        <th class="px-6 py-3 text-left">Category</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Phone</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $supplier)
                        <tr class="border-t">
                            <td class="px-6 py-4 font-medium">{{ $supplier->name }}</td>
                            <td class="px-6 py-4">{{ ucfirst($supplier->category) }}</td>
                            <td class="px-6 py-4">{{ $supplier->contact_email }}</td>
                            <td class="px-6 py-4">{{ $supplier->phone ?? '—' }}</td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <button onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'edit-supplier-{{ $supplier->id }}'}))"
                                        class="text-xs font-medium text-brand-600 hover:text-brand-700">Edit</button>
                                <form method="POST" action="{{ route('admin.suppliers.destroy', $supplier) }}"
                                      class="inline" onsubmit="return confirm('Remove this supplier and its login?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-red-500 hover:text-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>

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
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Phone number</label>
                                        <input type="text" name="phone" value="{{ $supplier->phone }}" class="w-full rounded-lg border-slate-200 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Address</label>
                                        <input type="text" name="address" value="{{ $supplier->address }}" class="w-full rounded-lg border-slate-200 text-sm">
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
                </tbody>
            </table>
        @endif
    </div>

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