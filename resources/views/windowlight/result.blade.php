@props(['result'])

@php

$autoWidth = true; // Todo: Add this as an option

if ($autoWidth) {
    $width = App\Helpers\ResultWindowHelper::calculateWindowWidth($result);
}

$padding = 1; // Rem
$width = $width ?? 64; // Ch
@endphp

{{-- To improve compatability we use non-semantic elements, meaning divs everywhere, as well as inline styles. --}}

<style>
    #code-card-wrapper {
        /* Dynamic styles */
        padding: {{ $padding }}rem;
        width: {{ $width }}ch;
        background: {{ $background }};

        /* Alternative width */
        width: fit-content;

        /* Static styles */
        resize: horizontal;
        overflow: hidden;
        max-width: 100%;
        min-width: 320px;
    }

    @if($lineNumbers)
        #code-card-wrapper pre code.torchlight .line {
            /* Add matching padding to the right when using alternative width */
            padding-right: 1.5rem;
        }
    @endif

    #code-card-wrapper pre {
        /* Remove the default margin */
        margin: 0;
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
