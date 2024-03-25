@foreach($examples as $source => $contents)
    <img src="{{ $source }}" alt="{{ $contents }}" title="{{ $contents }}">
@endforeach