<table class="table">
    <thead>
    <tr>
        @foreach (array_keys($data->first()->toArray()) as $header)
            <th>{{ ucfirst(str_replace('_', ' ', $header)) }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $entry)
        @php
            $entry = $entry->toArray();
        @endphp
        <tr>
            @foreach ($entry as $value)
                <td>{{ $value ?: 'N/A' }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
