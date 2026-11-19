@props(['status'])
@php
    $classes = match ($status->value) {
        'open' => 'bg-sky-50 text-sky-700 ring-sky-600/20',
        'in_progress' => 'bg-indigo-50 text-indigo-700 ring-indigo-600/20',
        'waiting_parts' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        'completed' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'cancelled' => 'bg-slate-100 text-slate-600 ring-slate-500/20',
    };
@endphp
<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-2.5 py-1 text-xs font-bold ring-1 ring-inset {$classes}"]) }}>{{ $status->label() }}</span>
