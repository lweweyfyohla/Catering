<x-layouts.app title="{{ $supplier->name }} - CaterSource" page-title="Suppliers" :page-subtitle="now()->format('l, F j, Y')">

    <div x-data="{ selectedEventId: {{ $selectedEvent?->id ?? 'null' }} }">

    <a href="{{ route('suppliers.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-brand-600 mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to suppliers
    </a>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-6">
    <div class="h-40 md:h-48 bg-gradient-to-br from-brand-100 to-brand-100 overflow-hidden">
    @if ($supplier->image_cover)
        <img src="{{ asset('storage/'.$supplier->image_cover) }}" class="h-full w-full object-cover object-center" alt="{{ $supplier->name }} cover">
    @endif
</div>
    <div class="px-6 py-5 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="h-9 w-9 -mt-4 rounded-lg ring-4 ring-white bg-brand-50 shadow-sm overflow-hidden flex items-center justify-center shrink-0">
                @if ($supplier->logo)
                    <img src="{{ asset('storage/'.$supplier->logo) }}" class="h-full w-full object-cover" alt="{{ $supplier->name }} logo">
                @else
                    <span class="text-lg font-bold text-brand-500">{{ strtoupper(substr($supplier->name, 0, 2)) }}</span>
                @endif
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-900">{{ $supplier->name }}</h2>
                <p class="text-sm text-slate-400">{{ ucfirst($supplier->category) }} &middot; {{ $supplier->address ?? 'No address' }} &middot; ★ {{ number_format($supplier->stars, 1) }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'select-event'}))"
                    class="inline-flex items-center gap-2 rounded-lg bg-slate-50 border border-slate-200 text-slate-600 text-sm font-medium px-4 py-2.5">
                {{ $selectedEvent ? 'Sourcing for: '.$selectedEvent->event_name : 'Select event' }}
            </button>
            <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-4 py-2.5">
                View Cart
            </a>
        </div>
    </div>
</div>

    @if ($events->isEmpty())
        <div class="mb-6 rounded-lg bg-amber-50 border border-amber-100 text-amber-700 text-sm px-4 py-3">
            You need an active event before adding items to cart.
            <a href="{{ route('events.index') }}" class="font-medium underline">Create one first</a>.
        </div>
    @elseif (! $selectedEvent)
        <div class="mb-6 rounded-lg bg-amber-50 border border-amber-100 text-amber-700 text-sm px-4 py-3">
            Select which event you're sourcing for before adding items to cart.
            <button onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'select-event'}))" class="font-medium underline">Select event</button>.
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
                    <div class="aspect-square bg-slate-50 flex items-center justify-center">
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
                        <button @if($selectedEvent) onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'item-{{ $item->id }}'}))" @else disabled @endif
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
                        <div class="aspect-square bg-slate-50 flex items-center justify-center">
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
                                <input type="hidden" name="event_id" value="{{ $selectedEvent->id ?? '' }}">
                                <p class="text-sm text-slate-500">
                                    For: <strong>{{ $selectedEvent->event_name ?? 'No event selected' }}</strong>
                                    <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'select-event'}))" class="text-brand-600 underline text-xs ml-1">change</button>
                                </p>
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

    <x-modal name="select-event" max-width="sm">
        <div class="px-6 py-5 space-y-4">
            <h3 class="font-semibold text-slate-900">Which event is this for?</h3>
            <select x-model="selectedEventId" class="w-full rounded-lg border-slate-200 text-sm">
                @foreach ($events as $ev)
                    <option value="{{ $ev->id }}" @selected($selectedEvent && $selectedEvent->id === $ev->id)>{{ $ev->event_name }}</option>
                @endforeach
            </select>
            <button @click="window.location.href = window.location.pathname + '?event_id=' + selectedEventId"
                    class="w-full rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium py-2.5">
                Continue
            </button>
        </div>
    </x-modal>

    </div>
</x-layouts.app>