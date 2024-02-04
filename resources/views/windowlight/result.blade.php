@props(['result'])

@php

$autoWidth = true; // Todo: Add this as an option

if ($autoWidth) {
    $width = App\Helpers\ResultWindowHelper::calculateWindowWidth($result);
}

$padding = 2; // Rem
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
        margin: 1rem 0;
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

        @if($useHeader)
            /* Remove top border radius as that is handled by the header */
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        @endif
    }

    #code-card-wrapper:hover {
        /* Show the screenshot bounding box when highlighted */
        outline: rgba(255, 255, 255, 0.5) solid;
    }

    @if($useHeader)
        #code-card-header {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 14px;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
            background: #212529;
            color: #fff;
        }
        #code-card-header #header-buttons {
            /* Positions the buttons outside the flex container, making the header text centered */
            position: absolute;
        }

        #code-card-header .header-button {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            opacity: .75;
            margin-right: 1px;
        }

        #code-card-header .header-button-red {
            background: #f3615a;
        }

        #code-card-header .header-button-yellow {
            background: #f4c036;
        }

        #code-card-header .header-button-green {
            background: #3ccb3e;
        }

        #code-card-header #header-title {
            font-size: 14px;
            font-weight: 400;
            margin: 0 auto;
            color: rgba(255, 255, 255, .75);
            font-family: sans-serif;
        }
    @endif
</style>

<div id="code-card-wrapper">
    <div id="code-card">
        @if($useHeader)
            <div id="code-card-header">
                @if($headerButtons)
                    <span id="header-buttons">
                        <span class="header-button header-button-red"></span>
                        <span class="header-button header-button-yellow"></span>
                        <span class="header-button header-button-green"></span>
                    </span>
                @endif
                @if($headerText)
                    <span id="header-title">{{ $headerText }}</span>
                @endif
            </div>
        @endif
        <div id="torchlight-wrapper">
            {!! $result !!}
        </div>
    </div>
</div>
