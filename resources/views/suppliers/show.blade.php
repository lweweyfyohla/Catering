<x-layouts.app title="{{ $supplier->name }} - CaterSource" page-title="Suppliers" :page-subtitle="now()->format('l, F j, Y')">

    <a href="{{ route('suppliers.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-brand-600 mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to suppliers
    </a>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-6">
        <div class="h-32 bg-gradient-to-br from-brand-200 to-brand-50"></div>
        <div class="px-6 py-5 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-900">{{ $supplier->name }}</h2>
                <p class="text-sm text-slate-400">{{ ucfirst($supplier->category) }} &middot; {{ $supplier->address ?? 'No address' }} &middot; ★ {{ number_format($supplier->stars, 1) }}</p>
            </div>
            <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-4 py-2.5">
                View Cart
            </a>
        </div>
    </div>

    @if ($events->isEmpty())
        <div class="mb-6 rounded-lg bg-amber-50 border border-amber-100 text-amber-700 text-sm px-4 py-3">
            You need an active event before adding items to cart.
            <a href="{{ route('events.index') }}" class="font-medium underline">Create one first</a>.
        </div>
    @endif

    @if ($supplier->menuItems->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm px-6 py-12 text-center text-sm text-slate-400">
            This supplier hasn't added any menu items yet.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($supplier->menuItems as $item)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="h-3 bg-brand-500"></div>
                    <div class="h-32 bg-slate-50 flex items-center justify-center">
                        @if ($item->image)
                            <img src="{{ asset('storage/'.$item->image) }}" class="h-full w-full object-cover" alt="{{ $item->item_name }}">
                        @else
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 6h16v12H4V6z"/></svg>
                        @endif
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-slate-900">{{ $item->item_name }}</h4>
                        <p class="text-brand-600 font-bold text-sm mt-0.5">${{ number_format($item->price, 2) }}</p>
                        <p class="text-xs text-slate-400 mt-1 line-clamp-2">{{ $item->description }}</p>
                        <button @if($events->isNotEmpty()) onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'item-{{ $item->id }}'}))" @else disabled @endif
                                class="mt-3 w-full rounded-lg bg-brand-500 hover:bg-brand-600 disabled:opacity-40 disabled:cursor-not-allowed text-white text-sm font-medium py-2 transition">
                            + Add to Cart
                        </button>
                    </div>
                </div>

                <x-modal :name="'item-'.$item->id" max-width="sm">
                    <form method="POST" action="{{ route('cart.store', $item) }}">
                        @csrf
                        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                            <h3 class="font-semibold text-slate-900">{{ $item->item_name }}</h3>
                            <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))" class="text-slate-400 hover:text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <div class="h-40 bg-slate-50 flex items-center justify-center">
                            @if ($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}" class="h-full w-full object-cover" alt="">
                            @else
                                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 6h16v12H4V6z"/></svg>
                            @endif
                        </div>
                        <div class="px-6 py-4 space-y-3">
                            <p class="text-sm text-slate-500">{{ $item->description }}</p>
                            <p class="text-brand-600 font-bold">${{ number_format($item->price, 2) }}</p>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">For event</label>
                                <select name="event_id" required class="w-full rounded-lg border-slate-200 text-sm">
                                    @foreach ($events as $ev)
                                        <option value="{{ $ev->id }}">{{ $ev->event_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Note</label>
                                <input type="text" name="note" placeholder="Add your request ..." class="w-full rounded-lg border-slate-200 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Amount</label>
                                <input type="number" name="quantity" value="1" min="1" required class="w-28 rounded-lg border-slate-200 text-sm">
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-100">
                            <button type="submit" class="w-full rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium py-2.5">Add to Cart</button>
                        </div>
                    </form>
                </x-modal>
            @endforeach
        </div>
    @endif

    {{-- Admin: quick-add menu item --}}
    <div class="mt-8">
        <button onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'new-menu-item'}))"
                class="inline-flex items-center gap-2 rounded-lg border border-dashed border-slate-300 text-slate-500 text-sm font-medium px-4 py-2.5 hover:bg-slate-50">
            + Add menu item to {{ $supplier->name }}
        </button>
    </div>

    <x-modal name="new-menu-item" max-width="md">
        <form method="POST" action="{{ route('menu-items.store', $supplier) }}" enctype="multipart/form-data">
            @csrf
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-900">New menu item</h3>
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-6 py-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Item name</label>
                    <input type="text" name="item_name" required class="w-full rounded-lg border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
                    <textarea name="description" rows="2" class="w-full rounded-lg border-slate-200 text-sm"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Price ($)</label>
                        <input type="number" step="0.01" name="price" required class="w-full rounded-lg border-slate-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full text-sm">
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-100">
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))"
                        class="rounded-lg border border-slate-200 text-slate-600 text-sm font-medium px-4 py-2 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-4 py-2">Add item</button>
            </div>
        </form>
    </x-modal>
</x-layouts.app>
