@props(['percentage', 'label', 'scale' => 2])

<div class="whitespace-nowrap rounded px-2 mb-1 bg-[#D9EDFC] group-hover:bg-[#B9DEF9]" style="width: {{ round($percentage * $scale) }}%; min-width: {{ round(8 - $scale) }}%; max-width: 50vw;">
    {{ $label }}
</div>