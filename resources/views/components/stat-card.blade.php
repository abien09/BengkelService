@props([
    'title' => 'Metrik',
    'value' => '0',
    'subtitle' => '',
    'icon' => '📊',
    'color' => 'red' // red, amber, blue, emerald
])

@php
    $bgIcon = [
        'red'     => 'bg-red-50 text-red-600',
        'amber'   => 'bg-amber-50 text-amber-600',
        'blue'    => 'bg-blue-50 text-blue-600',
        'emerald' => 'bg-emerald-50 text-emerald-600',
    ][$color] ?? 'bg-slate-100 text-slate-700';
@endphp

<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between group hover:border-red-500 transition">
    <div>
        <span class="text-[11px] font-bold font-mono text-slate-400 uppercase tracking-wider block">{{ $title }}</span>
        <strong class="text-3xl font-black text-slate-900 mt-1 block">
            {{ $value }}
        </strong>
        @if($subtitle)
            <span class="text-[11px] font-medium mt-1 inline-block text-slate-500">{{ $subtitle }}</span>
        @endif
    </div>
    <div class="w-12 h-12 {{ $bgIcon }} rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition">
        {{ $icon }}
    </div>
</div>