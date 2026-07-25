<x-layouts.app title="Events - CaterSource" page-title="Events" :page-subtitle="now()->format('l, F j, Y')">

    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-slate-500">Manage all catering events and sourcing requests</p>
        <button onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'new-event'}))"
                class="inline-flex items-center gap-2 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-4 py-2.5 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New event
        </button>
    </div>

    <div class="flex flex-wrap gap-2 mb-6">
        @foreach (['all' => 'All', 'draft' => 'Draft', 'sourcing' => 'Sourcing', 'ordered' => 'Ordered', 'delivered' => 'Delivered', 'closed' => 'Closed'] as $key => $label)
            <a href="{{ route('events.index', $key === 'all' ? [] : ['status' => $key]) }}"
               class="px-4 py-1.5 rounded-full text-sm font-medium transition
                      {{ $activeStatus === $key ? 'bg-brand-500 text-white' : 'bg-white text-slate-500 border border-slate-200 hover:bg-slate-50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        @if ($events->isEmpty())
            <p class="px-6 py-12 text-center text-sm text-slate-400">No events found for this filter.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-slate-400 text-xs uppercase tracking-wide bg-slate-50">
                            <th class="px-6 py-3 font-medium">Event Name</th>
                            <th class="px-6 py-3 font-medium">Type</th>
                            <th class="px-6 py-3 font-medium">Date</th>
                            <th class="px-6 py-3 font-medium">Guests</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($events as $event)
                            <tr>
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $event->event_name }}</td>
                                <td class="px-6 py-4">
                                    <span class="status-pill bg-slate-100 text-slate-500">{{ ucfirst($event->event_type) }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-500">{{ $event->event_date->format('M j, Y') }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $event->guest_count }}</td>
                                <td class="px-6 py-4"><x-status-badge :status="$event->status" /></td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="window.dispatchEvent(new CustomEvent('open-modal', {detail: 'event-{{ $event->id }}'}))"
                                                class="p-1.5 rounded-lg text-slate-400 hover:text-brand-600 hover:bg-brand-50" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z"/><circle cx="12" cy="12" r="3" stroke-width="2"/></svg>
                                        </button>
                                        @if ($event->status === 'draft')
                                            <form method="POST" action="{{ route('events.start-sourcing', $event) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-brand-50 text-brand-600 text-xs font-medium px-3 py-1.5 hover:bg-brand-100">
                                                    Start Sourcing
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('suppliers.index') }}" class="inline-flex items-center gap-1 rounded-lg bg-slate-50 text-slate-500 text-xs font-medium px-3 py-1.5 hover:bg-slate-100">
                                                Browse suppliers
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- New Event Modal --}}
    <x-modal name="new-event" max-width="lg">
        <form method="POST" action="{{ route('events.store') }}">
            @csrf
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-900">New event</h3>
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-6 py-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Event name</label>
                    <input type="text" name="event_name" required placeholder="e.g. Annual Gala Dinner"
                           class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Event type</label>
                        <select name="event_type" required class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400 text-sm">
                            <option value="wedding">Wedding</option>
                            <option value="corporate">Corporate</option>
                            <option value="social">Social</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Event date</label>
                        <input type="date" name="event_date" required class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400 text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Number of guests</label>
                        <input type="number" name="guest_count" min="1" required class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Event status</label>
                        <select name="status" required class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400 text-sm">
                            <option value="draft">Draft</option>
                            <option value="sourcing">Sourcing</option>
                            <option value="ordered">Ordered</option>
                            <option value="delivered">Delivered</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Notes</label>
                    <textarea name="notes" rows="3" placeholder="Add any additional notes or requirements..."
                              class="w-full rounded-lg border-slate-200 focus:border-brand-400 focus:ring-brand-400 text-sm"></textarea>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-100">
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))"
                        class="rounded-lg border border-slate-200 text-slate-600 text-sm font-medium px-4 py-2 hover:bg-slate-50">Cancel</button>
                <button type="submit" class="rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-4 py-2">Create event</button>
            </div>
        </form>
    </x-modal>

    {{-- Event Detail Modals --}}
    @foreach ($events as $event)
        <x-modal :name="'event-'.$event->id" max-width="lg">
            <div x-data="{ editing: false }">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h3 class="font-semibold text-slate-900" x-show="!editing">{{ $event->event_name }}</h3>
                    <h3 class="font-semibold text-slate-900" x-show="editing" x-cloak>Edit event</h3>
                    <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- View mode --}}
                <div x-show="!editing" class="px-6 py-5">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-400">Event type</p>
                            <p class="text-sm font-medium text-slate-800 mt-1">{{ ucfirst($event->event_type) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Event date</p>
                            <p class="text-sm font-medium text-slate-800 mt-1">{{ $event->event_date->format('F j, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Guests</p>
                            <p class="text-sm font-medium text-slate-800 mt-1">{{ $event->guest_count }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Status</p>
                            <div class="mt-1"><x-status-badge :status="$event->status" /></div>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Created</p>
                            <p class="text-sm font-medium text-slate-800 mt-1">{{ $event->created_at->format('M j, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Latest updated</p>
                            <p class="text-sm font-medium text-slate-800 mt-1">{{ $event->updated_at->format('M j, Y') }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-xs text-slate-400 mb-1">Notes</p>
                        <p class="text-sm text-slate-600 bg-slate-50 rounded-lg px-3 py-2.5">{{ $event->notes ?: 'No additional notes provided.' }}</p>
                    </div>
                </div>

                {{-- Edit mode --}}
                <form x-show="editing" x-cloak method="POST" action="{{ route('events.update', $event) }}" class="px-6 py-5 space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Event name</label>
                        <input type="text" name="event_name" value="{{ $event->event_name }}" required class="w-full rounded-lg border-slate-200 text-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Event type</label>
                            <select name="event_type" class="w-full rounded-lg border-slate-200 text-sm">
                                @foreach (['wedding','corporate','social','other'] as $t)
                                    <option value="{{ $t }}" @selected($event->event_type === $t)>{{ ucfirst($t) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Event date</label>
                            <input type="date" name="event_date" value="{{ $event->event_date->format('Y-m-d') }}" required class="w-full rounded-lg border-slate-200 text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Guests</label>
                            <input type="number" name="guest_count" value="{{ $event->guest_count }}" min="1" required class="w-full rounded-lg border-slate-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Status</label>
                            <select name="status" class="w-full rounded-lg border-slate-200 text-sm">
                                @foreach (['draft','sourcing','ordered','delivered','closed'] as $s)
                                    <option value="{{ $s }}" @selected($event->status === $s)>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Notes</label>
                        <textarea name="notes" rows="3" class="w-full rounded-lg border-slate-200 text-sm">{{ $event->notes }}</textarea>
                    </div>
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="editing = false" class="rounded-lg border border-slate-200 text-slate-600 text-sm font-medium px-4 py-2">Cancel</button>
                        <button type="submit" class="rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-4 py-2">Save changes</button>
                    </div>
                </form>

                <div x-show="!editing" class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-100">
                    <form method="POST" action="{{ route('events.destroy', $event) }}"
          onsubmit="return confirm('Delete this event? This cannot be undone.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="rounded-lg border border-red-200 text-red-600 text-sm font-medium px-4 py-2 hover:bg-red-50">
            Delete
        </button>
                </form>

                <button type="button" onclick="window.dispatchEvent(new CustomEvent('close-modal'))"
            class="rounded-lg border border-slate-200 text-slate-600 text-sm font-medium px-4 py-2 hover:bg-slate-50">Close</button>
                <button type="button" @click="editing = true" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 text-slate-600 text-sm font-medium px-4 py-2 hover:bg-slate-50">
                    Edit
                </button>
                    <a href="{{ route('quotations.compare', $event) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-sm font-medium px-4 py-2">
                        Request Quote
                    </a>
            </div>
            </div>
        </x-modal>
    @endforeach

</x-layouts.app>
