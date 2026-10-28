@props([
    'type' => 'neutral', // pilihan: success, warning, danger, info, neutral
    'pulse' => false
])

@php
    $styles = [
        'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200 bg-dot-emerald-500',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-200 bg-dot-amber-500',
        'danger'  => 'bg-rose-50 text-rose-700 border-rose-200 bg-dot-rose-500',
        'info'    => 'bg-blue-50 text-blue-700 border-blue-200 bg-dot-blue-500',
        'neutral' => 'bg-slate-100 text-slate-700 border-slate-200 bg-dot-slate-500',
    ][$type] ?? 'bg-slate-100 text-slate-700 border-slate-200';

    $dots = [
        'success' => 'bg-emerald-500',
        'warning' => 'bg-amber-500',
        'danger'  => 'bg-rose-500',
        'info'    => 'bg-blue-500',
        'neutral' => 'bg-slate-500',
    ][$type] ?? 'bg-slate-500';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-bold rounded-full border {$styles}"]) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ $dots }} {{ $pulse ? 'animate-pulse' : '' }}"></span>
    <span>{{ $slot }}</span>
</span>