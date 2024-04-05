<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Raw Window Analytics Data</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
            padding: 2px 4px;
            white-space: nowrap;
        }
        th {
            text-transform: uppercase;
        }
        td {
            width: fit-content;
        }
        td span {
            white-space: normal;
            word-break: break-all;
        }
        table {
            border-collapse: collapse;
        }
        menu {
            display: flex;
            list-style: none;
            padding: 0;
            font-size: 16px;
            margin-bottom: 20px;
        }
        menu li {
            margin-right: 12px;
        }
    </style>
</head>
<body>
<header>
    <h1>Raw Window Analytics Data</h1>
    <menu role="toolbar">
        <li>
            <a href="{{ route('analytics') }}">Back to Main Dashboard</a>
        </li>
        <li>
            <a href="{{ route('analytics.json') }}">View Raw JSON</a>
        </li>
    </menu>
</header>
<main>
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
                <td><span>{{ $entry['user_agent'] ?: 'N/A' }}</span></td>
                <td>{{ $entry['anonymous_id'] }}</td>
                <td>{{ $entry['created_at'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>
</body>
</html>