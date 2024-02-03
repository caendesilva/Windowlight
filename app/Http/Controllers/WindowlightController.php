<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateImageRequest;

class WindowlightController extends Controller
{
    public function show()
    {
        return view('windowlight');
    }

    public function store(CreateImageRequest $request)
    {
        $validated = $request->validated();

        // Todo: Get code snippet
        $result = $validated['code'];

        return redirect()->route('home');
    }
}
