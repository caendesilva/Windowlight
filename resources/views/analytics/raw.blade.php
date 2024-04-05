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
            max-width: 50ch;
            overflow-x: auto;
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
    <section>
        <h2>Table: <code>page_view_events</code></h2>
        @include('simple-table', ['data' => $pageViewEvents])
    </section>
</main>
<hr>
<footer>
    <small>
        Generated in {{ round((microtime(true) - LARAVEL_START) * 1000, 2) }}ms
    </small>
</footer>
</body>
</html>