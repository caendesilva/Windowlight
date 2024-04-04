<?php

namespace App\Http\Controllers;

use App\Models\Analytics\PageViewEvent;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function show(Request $request)
    {
        return view('analytics', [
            'pageViews' => PageViewEvent::all(),
            'traffic' => $this->getTrafficData(),
        ]);
    }

    public function raw(Request $request)
    {
        return view('analytics.raw', [
            'data' => PageViewEvent::all()
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
        $pageViewEvents = PageViewEvent::all();

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
}
