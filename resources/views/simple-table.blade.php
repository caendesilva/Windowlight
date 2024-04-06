@php
$format = function (string $key, mixed $value): string {
    if (is_bool($value) || ((str_starts_with($key, 'is') || str_starts_with($key, 'has')) && ($value === 0 || $value === 1))) {
        return $value ? 'true' : 'false';
    }

    return (string) $value ?: 'N/A';
};
@endphp
<table class="table">
    <thead>
    <tr>
        @foreach (array_keys($data->first()->toArray()) as $header)
            <th>{{ ucfirst(str_replace('_', ' ', Str::snake($header))) }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $entry)
        @php
            $entry = $entry->toArray();
        @endphp
        <tr>
            @foreach ($entry as $key => $value)
                <td>{{ $format($key, $value) }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
