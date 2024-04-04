<?php

namespace App\Http\Controllers;

use App\Models\Analytics\PageViewEvent;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function show(Request $request)
    {
        return view('analytics', [
            'pageViews' => PageViewEvent::all()
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
}
