@props(['label', 'state', 'isLast' => false])

<div class="flex items-center {{ $isLast ? '' : 'flex-1' }}">
    <div class="flex flex-col items-center gap-2">
        @if ($state === 'done')
            <div class="h-8 w-8 rounded-full bg-brand-500 text-white flex items-center justify-center shrink-0">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>
        @elseif ($state === 'current')
            <div class="h-8 w-8 rounded-full border-2 border-brand-500 bg-white flex items-center justify-center shrink-0">
                <div class="h-3 w-3 rounded-full bg-brand-500"></div>
            </div>
        @else
            <div class="h-8 w-8 rounded-full border-2 border-slate-200 bg-white shrink-0"></div>
        @endif
        <span class="text-xs {{ $state === 'pending' ? 'text-slate-400' : 'text-slate-600' }}">{{ $label }}</span>
    </div>

    @unless ($isLast)
        <div class="flex-1 h-0.5 -mt-5 {{ $state === 'done' ? 'bg-brand-500' : 'bg-slate-200' }}"></div>
    @endunless
</div>
