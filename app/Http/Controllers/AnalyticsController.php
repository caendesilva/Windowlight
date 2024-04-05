<?php

namespace App\Http\Controllers;

use App\Models\Analytics\PageViewEvent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AnalyticsController extends Controller
{
    public function show(Request $request)
    {
        $pageViews = PageViewEvent::all();
        $traffic = $this->getTrafficData();
        $stats = $this->getStatsData($pageViews, $traffic);
        $pages = $this->getPagesData($pageViews);

        return view('analytics', [
            'pageViews' => $pageViews,
            'stats' => $stats,
            'traffic' => $traffic,
            'pages' => $pages,
        ]);
    }

    public function raw(Request $request)
    {
        return view('analytics.raw', [
            'data' => PageViewEvent::all(),
        ]);
    }

    public function json(Request $request)
    {
        // Unless ?pretty=false is passed, we'll return pretty-printed JSON
        return response()->json(PageViewEvent::all(), options: $request->query('pretty') === 'false' ? 0 : JSON_PRETTY_PRINT);
    }

    protected function getTrafficData(): array
    {
        // Get all page view events
        $pageViewEvents = PageViewEvent::all()->sortBy('created_at');

        // Group page view events by date
        $pageViewsByDate = $pageViewEvents->groupBy(function ($pageView) {
            return Carbon::parse($pageView->created_at)->toDateString();
        });

        // Initialize arrays to store total and unique visitor counts for each day
        $totalVisitorCounts = [];
        $uniqueVisitorCounts = [];

        // Iterate over grouped page views by date
        $pageViewsByDate->each(function ($pageViews, $date) use (&$totalVisitorCounts, &$uniqueVisitorCounts) {
            // Count total page views for the day
            $totalVisitorCounts[$date] = $pageViews->count();

            // Count unique page views for the day (based on anonymous_id)
            $uniqueVisitorCounts[$date] = $pageViews->groupBy('anonymous_id')->count();
        });

        // Output the timeline of dates and visitor counts
        return [
            'dates' => array_keys($totalVisitorCounts),
            'total_visitor_counts' => array_values($totalVisitorCounts),
            'unique_visitor_counts' => array_values($uniqueVisitorCounts),
        ];
    }

    /** @return array<string, int> */
    protected function getStatsData(Collection $pageViews, array $traffic): array
    {
        return [
            'DB Records' => count($pageViews),
            'Total Visits' => array_sum($traffic['total_visitor_counts']),
            'Unique Visitors' => array_sum($traffic['unique_visitor_counts']),
            'Days Tracked' => count($traffic['dates']),
        ];
    }

    /** @return array<array{page: string, total: int, unique: int}> */
    protected function getPagesData(Collection $pageViews): array
    {
        return []; // Todo
    }
}
