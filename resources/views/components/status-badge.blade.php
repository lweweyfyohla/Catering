@props(['status'])
@php
    $map = [
        'draft' => 'bg-slate-100 text-slate-600',
        'sourcing' => 'bg-amber-50 text-amber-600',
        'ordered' => 'bg-blue-50 text-blue-600',
        'delivered' => 'bg-emerald-50 text-emerald-600',
        'closed' => 'bg-slate-100 text-slate-500',
        'pending' => 'bg-amber-50 text-amber-600',
        'accepted' => 'bg-emerald-50 text-emerald-600',
        'cancel' => 'bg-red-50 text-red-600',
        'cancelled' => 'bg-red-50 text-red-600',
        'issued' => 'bg-blue-50 text-blue-600',
        'confirmed' => 'bg-emerald-50 text-emerald-600',
        'paid' => 'bg-emerald-50 text-emerald-600',
        'failed' => 'bg-red-50 text-red-600',
        'refunded' => 'bg-slate-100 text-slate-600',
    ];
    $classes = $map[$status] ?? 'bg-slate-100 text-slate-600';
@endphp
<span class="status-pill {{ $classes }}">{{ ucfirst($status) }}</span>
