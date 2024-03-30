<style>
    .example-container {
        position: relative;
    }
    .example-text {
        position: absolute;
        top: 0;
        left: 0;
        margin: 8.5rem 7.25rem;
        font-size: 1.75rem;
        line-height: 1.35;
        font-family: monospace;
        letter-spacing: -0.1rem;
        display: block;
        overflow: visible;
        color: transparent;
    }
    .example-text.minimal {
        margin: 4.8rem 5rem;
    }
</style>

@foreach($examples as $source => $contents)
<figure class="example-container">
    <img class="example-image" src="{{ $source }}" alt="{{ $contents }}" title="{{ $contents }}">
    <pre class="example-text {{ $loop->last ? 'minimal' : '' }}">{!! $contents !!}</pre>
</figure>
@endforeach