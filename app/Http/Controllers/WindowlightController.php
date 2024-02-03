<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateImageRequest;

class WindowlightController extends Controller
{
    public function show()
    {
        /** @var ?string $result */
        $result = session('result');

        return view('windowlight', [
            'result' => $result,
        ]);
    }

    public function store(CreateImageRequest $request)
    {
        $validated = $request->validated();

        // Todo: Get code snippet
        $result = $validated['code'];

        // Store in session
        $request->session()->put('result', $result);

        return redirect()->route('home');
    }
}
