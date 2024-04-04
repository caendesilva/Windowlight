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
}
