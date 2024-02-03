@props(['result'])

@php
$padding = 1; // Rem
$width = 64; // Ch
@endphp

{{-- To improve compatability we use non-semantic elements, meaning divs everywhere, as well as inline styles. --}}

<style>
    #code-card-wrapper {
        /* Dynamic styles */
        padding: {{ $padding }}rem;
        width: {{ $width }}ch;

        /* Static styles */
        resize: horizontal;
        overflow: hidden;
        max-width: 100%;
    }

    #code-card-wrapper:hover {
        /* Show the screenshot bounding box when highlighted */
        outline: rgba(255, 255, 255, 0.5) solid;
    }
</style>

<div id="code-card-wrapper">
    <div id="code-card">
        <div id="torchlight-wrapper">
            {!! $result !!}
        </div>
    </div>
</div>
