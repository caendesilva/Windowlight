<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Page</th>
        <th>Referrer</th>
        <th>User Agent</th>
        <th>Anonymous ID</th>
        <th>Created At</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $entry)
        <tr>
            <td>{{ $entry['id'] }}</td>
            <td>{{ $entry['page'] }}</td>
            <td>{{ $entry['referrer'] ?: 'N/A' }}</td>
            <td>{{ $entry['user_agent'] ?: 'N/A' }}</td>
            <td>{{ $entry['anonymous_id'] }}</td>
            <td>{{ $entry['created_at'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>