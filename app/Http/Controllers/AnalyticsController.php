<?php

namespace App\Http\Controllers;

use App\Models\Analytics\CodeGenerationEvent;
use App\Models\Analytics\PageViewEvent;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function show(): View
    {
        $time = microtime(true);

        [$pageViews, $traffic, $stats, $pages, $referrers, $languages] = $this->getCachedData();

        return view('analytics', [
            'pageViews' => $pageViews,
            'stats' => $stats,
            'traffic' => $traffic,
            'pages' => $pages,
            'referrers' => $referrers->where('is_ref', false),
            'refs' => $referrers->where('is_ref', true),
            'pageSize' => 15,
            'time' => sprintf('%.2fms', (microtime(true) - $time) * 1000),
            'languages' => $languages,
        ]);
    }

    public function raw(): View
    {
        return view('analytics.raw', [
            'pageViewEvents' => PageViewEvent::all(),
            'codeGenerationEvents' => CodeGenerationEvent::all(),
        ]);
    }

    public function json(Request $request): JsonResponse
    {
        // Unless ?pretty=false is passed, we'll return pretty-printed JSON

        return response()->json(PageViewEvent::all(), options: $request->query('pretty') === 'false' ? 0 : JSON_PRETTY_PRINT);
    }

    protected function getCachedData(): array
    {
        // Temporarily disable cache as we don't yet have that many records
        return $this->getData();

        // With ~5000 records, this takes about ~500ms on an M2 Mac. Caching it reduces it to ~30ms.

        $cacheKey = 'analytics-data-'.sha1_file(__FILE__); // Invalidate cache if this file changes
        $cacheDuration = now()->addMinutes(5);

        return Cache::remember($cacheKey, $cacheDuration, fn (): array => $this->getData());
    }

    protected function getData(): array
    {
        $pageViews = PageViewEvent::all();
        $generatedImages = CodeGenerationEvent::all();

        $traffic = $this->getTrafficData();
        $stats = $this->getStatsData($pageViews, $generatedImages, $traffic);
        $pages = $this->getPagesData($pageViews);
        $referrers = $this->getReferrersData($pageViews);

        $languages = $this->getPopularLanguages($generatedImages);

        return [$pageViews, $traffic, $stats, $pages, $referrers, $languages];
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
    protected function getStatsData(EloquentCollection $pageViews, EloquentCollection $generatedImages, array $traffic): array
    {
        return [
            'DB Records' => count($pageViews) + count($generatedImages),
            'Total Visits' => array_sum($traffic['total_visitor_counts']),
            'Unique Visitors' => array_sum($traffic['unique_visitor_counts']),
            'Days Tracked' => count($traffic['dates']),
            'Referrers' => $pageViews->groupBy('referrer')->count(),
            'Generated Images' => $generatedImages->count(),
        ];
    }

    /** @return array<array{page: string, total: int, unique: int, percentage: float}> */
    protected function getPagesData(EloquentCollection $pageViews): array
    {
        $domain = parse_url(url('/'), PHP_URL_HOST);
        $totalPageViews = $pageViews->count();

        return $pageViews->groupBy('page')->map(function (EloquentCollection $pageViews, string $page) use ($domain, $totalPageViews): array {
            return [
                'page' => rtrim(Str::after($page, $domain), '/') ?: '/',
                'unique' => $pageViews->groupBy('anonymous_id')->count(),
                'total' => $pageViews->count(),
                'percentage' => $totalPageViews > 0 ? ($pageViews->count() / $totalPageViews) * 100 : 0,
            ];
        })->sortByDesc('total')->values()->toArray();
    }

    /** @return \Illuminate\Support\Collection<array{referrer: string, total: int, unique: int, percentage: float}> */
    protected function getReferrersData(EloquentCollection $pageViews): Collection
    {
        $totalPageViews = $pageViews->count();

        return $pageViews->groupBy('referrer')->map(function (EloquentCollection $pageViews, ?string $referrer) use ($totalPageViews): array {
            return [
                'referrer' => $referrer ?: 'Direct / Unknown',
                'unique' => $pageViews->groupBy('anonymous_id')->count(),
                'total' => $pageViews->count(),
                'percentage' => $totalPageViews > 0 ? ($pageViews->count() / $totalPageViews) * 100 : 0,
                'is_ref' => $referrer !== null && $referrer !== 'Direct / Unknown' && str_starts_with($referrer, '?ref='),
            ];
        })->sortByDesc('total')->values();
    }

    /** @return array<string, int> */
    protected function getPopularLanguages(EloquentCollection $generatedImages): array
    {
        return $generatedImages->groupBy('language')->mapWithKeys(fn(EloquentCollection $events, string $language): array => [
            $language => $events->count(),
        ])->sort()->take(-10)->all();
    }
}
