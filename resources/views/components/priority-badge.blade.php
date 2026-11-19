@props(['priority'])
@php
    $classes = match ($priority->value) {
        'low' => 'text-slate-500',
        'normal' => 'text-slate-600',
        'high' => 'text-orange-600',
        'urgent' => 'text-rose-600',
    };
@endphp
<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1 text-xs font-bold {$classes}"]) }}><span class="h-1.5 w-1.5 rounded-full bg-current"></span>{{ $priority->label() }}</span>
