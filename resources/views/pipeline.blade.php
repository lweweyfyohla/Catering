<x-layouts.app title="Procurement Pipeline - CaterSource" page-title="Procurement Pipeline" :page-subtitle="now()->format('l, F j, Y')">

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-slate-900">All Events</h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-brand-600 font-medium hover:underline">Back to dashboard</a>
        </div>

        @if ($pipelineEvents->isEmpty())
            <p class="px-6 py-10 text-center text-sm text-slate-400">No active events in the pipeline.</p>
        @else
            <div class="space-y-4">
                @foreach ($pipelineEvents as $item)
                    <x-pipeline-card :item="$item" />
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.app>