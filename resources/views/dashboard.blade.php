<x-layouts.app title="Dashboard - CaterSource" page-title="Dashboard" :page-subtitle="now()->format('l, F j, Y')">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach ([
            ['label' => 'Total Events', 'value' => $stats['total_events'], 'icon' => 'calendar'],
            ['label' => 'Active Sourcing', 'value' => $stats['active_sourcing'], 'icon' => 'document'],
            ['label' => 'Pending Quotes', 'value' => $stats['pending_quotes'], 'icon' => 'building'],
            ['label' => 'Pending Deliveries', 'value' => $stats['pending_deliveries'], 'icon' => 'truck'],
        ] as $card)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-400">{{ $card['label'] }}</p>
                    <div class="h-9 w-9 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center">
                        <x-nav-icon :name="$card['icon']" />
                    </div>
                </div>
                <p class="mt-3 text-2xl font-bold text-slate-900">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    @if ($pipelineEvents->isNotEmpty())
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-slate-900">Procurement Timeline</h2>
                <a href="{{ route('pipeline.index') }}" class="text-sm text-brand-600 font-medium hover:underline">See more</a>
            </div>

            <div class="space-y-4">
                @foreach ($pipelineEvents as $item)
                    <x-pipeline-card :item="$item" />
                @endforeach
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-900">Upcoming Events</h2>
            <a href="{{ route('events.index') }}" class="text-sm text-brand-600 font-medium hover:underline">View all</a>
        </div>

        @if ($upcomingEvents->isEmpty())
            <p class="px-6 py-10 text-center text-sm text-slate-400">No events yet. Create your first event to get started.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-slate-400 text-xs uppercase tracking-wide">
                            <th class="px-6 py-3 font-medium">Event Name</th>
                            <th class="px-6 py-3 font-medium">Type</th>
                            <th class="px-6 py-3 font-medium">Date</th>
                            <th class="px-6 py-3 font-medium">Guests</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($upcomingEvents as $event)
                            <tr>
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $event->event_name }}</td>
                                <td class="px-6 py-4">
                                    <span class="status-pill bg-slate-100 text-slate-500">{{ ucfirst($event->event_type) }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-500">{{ $event->event_date->format('M j, Y') }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $event->guest_count }}</td>
                                <td class="px-6 py-4"><x-status-badge :status="$event->status" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts.app>
