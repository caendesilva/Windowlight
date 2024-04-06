<x-app-layout title="Analytics">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <header class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 pt-4 pb-2">
                <div class="basic-prose mx-auto text-gray-800 dark:text-gray-200 leading-tight">
                    <h1 class="text-3xl font-bold">Public Analytics Dashboard</h1>
                    <p class="text-center text-gray-600 dark:text-gray-400 -mt-2 mb-0">
                        All Windowlight Analytics data is publicly available. You can also view the raw data as
                        <a href="{{ route('analytics.raw') }}" class="text-sm">HTML</a>
                        or <a href="{{ route('analytics.json') }}" class="text-sm">JSON</a>.
                    </p>
                </div>
            </header>

            <main class="dark:text-gray-200 text-gray-800">
                <section class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 mt-4">
                    <ul class="flex flex-row flex-wrap justify-center sm:justify-between items-center">
                        @foreach($stats as $label => $value)
                            <li class="px-2 my-2 sm:my-0 text-center">
                                <dl class="flex flex-col">
                                    <dt class="text-lg font-bold">{{ number_format($value) }}</dt>
                                    <dd class="text-sm text-gray-600 dark:text-gray-400">{{ $label }}</dd>
                                </dl>
                            </li>
                        @endforeach
                    </ul>
                </section>

                <section class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mt-4">
                    <header class="flex justify-between items-center -mt-2 mb-2">
                        <h2 class="text-xl font-bold">Site Visits</h2>
                    </header>

                    @if(count($traffic['dates']) > 0)
                        <!-- Create a canvas element for the chart -->
                        <canvas id="pageViewsChart" width="800" height="400"></canvas>
                    @else
                        <p>No page views data available.</p>
                    @endif
                </section>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-4">
                    <section class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 pb-4 mt-4 col-span-3">
                        <header class="flex justify-between items-center -mt-2 mb-2">
                            <h2 class="text-xl font-bold">Page Views</h2>
                        </header>
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full" x-data="{ currentPage: 1, pageSize: {{ $pageSize }}, totalPages: Math.ceil({{ count($pages) }} / {{ $pageSize }}) }">
                                <thead class="text-gray-600 dark:text-gray-400">
                                <tr>
                                    <th class="text-start pb-2 pr-2">Page</th>
                                    <th class="text-end px-2 pb-2">Visitors</th>
                                    <th class="text-end pl-2 pb-2">Views</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pages as $data)
                                    <tr class="group" x-show="currentPage * pageSize > {{ $loop->index }} && {{ $loop->index }} >= (currentPage - 1) * pageSize" {{ $loop->index >= $loop->count - 2 ? 'x-cloak' : '' }}>
                                        <td class="text-start w-full pr-2">
                                            <x-analytics.table-percentage-row :percentage="$data['percentage']" :label="$data['page']" scale="1" />
                                        </td>
                                        <td class="text-end px-2">{{ $data['unique'] }}</td>
                                        <td class="text-end pl-2 ">{{ $data['total'] }}</td>
                                    </tr>
                                @endforeach
                                @include('components.analytics.table-padding-row', ['records' => $pages, 'pageSize' => $pageSize])
                                </tbody>
                                <tfoot>
                                @include('components.analytics.table-navigation')
                                </tfoot>
                            </table>
                        </div>
                    </section>

                    <section x-data="{ tab: 'referrers', currentPage: 1, pageSize: {{ $pageSize }}, totalPages: Math.ceil({{ count($referrers) }} / {{ $pageSize }}) }" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 pb-4 mt-4 col-span-2">
                        <header class="flex justify-between items-center -mt-2 mb-2">
                            <nav class="flex space-x-2">
                                <button @click="tab = 'referrers'; currentPage = 1; totalPages = Math.ceil({{ count($referrers) }} / {{ $pageSize }})" :class="{ 'opacity-100': tab === 'referrers', 'opacity-50': tab !== 'referrers' }">
                                    <h2 class="text-xl font-bold">Referrers</h2>
                                </button>
                                <button @click="tab = 'refs'; currentPage = 1; totalPages = Math.ceil({{ count($refs) }} / {{ $pageSize }})" :class="{ 'opacity-100': tab === 'refs', 'opacity-50': tab !== 'refs' }">
                                    <h2 class="text-xl font-bold">Refs</h2>
                                </button>
                            </nav>
                        </header>

                        <div class="overflow-x-auto">
                            <table class="table-auto w-full">
                                <thead class="text-gray-600 dark:text-gray-400">
                                <tr>
                                    <th class="text-start w-full pb-2 pr-2">
                                        <span x-show="tab === 'referrers'">Referrer</span>
                                        <span x-show="tab === 'refs'" x-cloak>Refs</span>
                                    </th>
                                    <th class="text-end px-2 pb-2">Visitors</th>
                                    <th class="text-end pl-2 pb-2">Views</th>
                                </tr>
                                </thead>
                                <tbody x-show="tab === 'referrers'">
                                @foreach($referrers as $data)
                                    <tr class="group" x-show="currentPage * pageSize > {{ $loop->index }} && {{ $loop->index }} >= (currentPage - 1) * pageSize" {{ $loop->index >= $loop->count - 2 ? 'x-cloak' : '' }}>
                                        <td class="text-start w-full pr-2">
                                            <x-analytics.table-percentage-row :percentage="$data['percentage']" :label="$data['referrer']" />
                                        </td>
                                        <td class="text-end px-2">{{ $data['unique'] }}</td>
                                        <td class="text-end pl-2">{{ $data['total'] }}</td>
                                    </tr>
                                @endforeach
                                @include('components.analytics.table-padding-row', ['records' => $referrers, 'pageSize' => $pageSize])
                                </tbody>
                                <tbody x-show="tab === 'refs'" x-cloak>
                                @foreach($refs as $data)
                                    <tr class="group" x-show="currentPage * pageSize > {{ $loop->index }} && {{ $loop->index }} >= (currentPage - 1) * pageSize" {{ $loop->index >= $loop->count - 2 ? 'x-cloak' : '' }}>
                                        <td class="text-start w-full pr-2">
                                            <x-analytics.table-percentage-row :percentage="$data['percentage']" :label="\Illuminate\Support\Str::after($data['referrer'], '?ref=')" />
                                        </td>
                                        <td class="text-end px-2">{{ $data['unique'] }}</td>
                                        <td class="text-end pl-2">{{ $data['total'] }}</td>
                                    </tr>
                                @endforeach
                                @include('components.analytics.table-padding-row', ['records' => $refs, 'pageSize' => $pageSize])
                                </tbody>
                                <tfoot>
                                @include('components.analytics.table-navigation')
                                </tfoot>
                            </table>
                        </div>
                    </section>
                </div>

                <section class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mt-4">
                    <header class="flex justify-between items-center -mt-2 mb-2">
                        <h2 class="text-xl font-bold">Popular Languages</h2>
                    </header>

                    <canvas id="languageChart" width="800" height="400"></canvas>
                </section>
            </main>

            <footer class="max-w-3xl mx-auto mt-8 -mb-4">
                <p class="text-center text-gray-600 dark:text-gray-400">
                    <small>
                        We do not utilize cookies or track any personal information.
                        Requests are anonymized in order to see daily unique visitor counts.
                        <br>
                        All analytics data is publicly available and can be viewed by anyone.
                    </small>
                    <small>
                        Request served in {{ $time }}.
                    </small>
                </p>
            </footer>
        </div>
    </div>

    @push('scripts')
        <!-- Include Chart.js library -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Visitor chart

                // Get the data from PHP
                const dates = @json($traffic['dates']);
                const totalVisitorCounts = @json($traffic['total_visitor_counts']);
                const uniqueVisitorCounts = @json($traffic['unique_visitor_counts']);

                // Create the chart
                const ctx = document.getElementById('pageViewsChart').getContext('2d');
                const pageViewsChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Total Visitors',
                            data: totalVisitorCounts,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                        }, {
                            label: 'Unique Visitors',
                            data: uniqueVisitorCounts,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        pointStyle: false
                    }
                });

                // Language chart
                // Get the data from PHP
                const languages = @json(array_keys($languages));
                const counts = @json(array_values($languages));

                // Create the chart
                const ctx2 = document.getElementById('languageChart').getContext('2d');
                const languageChart = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: languages,
                        datasets: [{
                            label: 'Language Frequency',
                            data: counts,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
