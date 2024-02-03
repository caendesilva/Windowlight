<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateImageRequest;
use App\TorchlightSnippetGenerator;

/**
 * Based on the internal HydePHP Torchlight snippet generator.
 *
 * @see https://github.com/hydephp/central/blob/main/app/Filament/Pages/Internal/TorchlightSnippetGenerator.php
 * @see https://github.com/hydephp/central/blob/main/resources/views/filament/pages/internal/torchlight-snippet-generator.blade.php
 */
class WindowlightController extends Controller
{
    public function show()
    {
        /** @var ?string $input */
        $input = old('code') ?? session('input');

        /** @var ?string $result */
        $result = session('result');

        $options = [
            'language' => old('language') ?? session('options.language') ?? 'php',
        ];

        $example = <<<'PHP'
        <?php
        
        use Illuminate\Support\Facades\Route;
        
        Route::get('/greeting', function () {
            return 'Hello World';
        });
        PHP;

        if ($input === null) {
            $input = $example;
        }

        if ($result === null) {
            $result = (new TorchlightSnippetGenerator($example, 'php'))->generate();
        }

        return view('windowlight', array_merge([
            'input' => $input,
            'result' => $result,
            'resultId' => hash('sha256', $result),
        ], $options));
    }

    public function store(CreateImageRequest $request)
    {
        $validated = $request->validated();

        $request->session()->put('input', $validated['code']);
        $request->session()->put('options.language', $validated['language'] ?? '');

        $torchlight = new TorchlightSnippetGenerator($validated['code'], $validated['language'] ?? 'plaintext');
        $result = $torchlight->generate();

        $request->session()->put('result', $result);

        return redirect()->route('home');
    }
}
