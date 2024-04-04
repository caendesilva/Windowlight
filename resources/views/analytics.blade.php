<x-app-layout title="Analytics">
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <header class="basic-prose mx-auto text-gray-800 dark:text-gray-200 leading-tight">
                    <h1 class="text-3xl font-bold">Public Analytics Dashboard</h1>
                </header>
            </div>

            <main class="dark:text-gray-200 text-gray-800">
                <section>
                    <header class="flex justify-between items-center mt-8 mb-4">
                        <h2 class="text-xl font-bold">
                            Page Visits
                            <small class="text-gray-600 dark:text-gray-400">({{ count($pageViews) }} records)</small>
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ array_sum($traffic['total_visitor_counts']) }} total visits
                            and {{ array_sum($traffic['unique_visitor_counts']) }} unique visitors
                            over the last {{ count($traffic['dates']) }} days
                        </p>
                    </header>

                    @if(count($traffic['dates']) > 0)
                        <!-- Create a canvas element for the chart -->
                        <canvas id="pageViewsChart" width="800" height="400"></canvas>
                    @else
                        <p>No page views data available.</p>
                    @endif
                </section>
            </main>
        </div>
    </div>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
        });
    </script>
</x-app-layout>
