@props(['item'])

@php
    $borderClass = match ($item['urgency']['label'] ?? null) {
        'Urgent' => 'border-red-100 bg-red-50/30',
        'Close to deadline' => 'border-amber-100 bg-amber-50/30',
        default => 'border-slate-100',
    };
@endphp

<div class="rounded-xl border {{ $borderClass }} p-5">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <h3 class="font-semibold text-slate-900">{{ $item['name'] }}</h3>
            @if ($item['urgency'])
                <span class="status-pill {{ $item['urgency']['class'] }}">{{ $item['urgency']['label'] }}</span>
            @endif
        </div>
        <div class="text-xs text-slate-400">
            Deadline: <span class="font-medium text-slate-600">{{ $item['deadline'] }}</span>
            <span class="ml-2 status-pill bg-slate-100 text-slate-500">{{ $item['days_left'] }}d left</span>
        </div>
    </div>

    <div class="flex items-start">
        @foreach ($item['steps'] as $step)
            <x-pipeline-step
                :label="$step['label']"
                :state="$step['state']"
                :is-last="$loop->last"
            />
        @endforeach
    </div>
</div>
