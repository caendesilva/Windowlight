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
        [$input, $result, $options] = $this->getSessionData();

        [$input, $result] = $this->injectExamplesForEmptyState($input, $result);

        return view('windowlight', array_merge([
            'input' => $input,
            'result' => $result,
            'resultId' => hash('sha256', $result.json_encode($options)),
        ], $options));
    }

    public function store(CreateImageRequest $request)
    {
        $validated = $request->validated();

        $request->session()->put('input', $validated['code']);
        $request->session()->put('options.language', $validated['language'] ?? '');
        $request->session()->put('options.lineNumbers', $validated['lineNumbers'] ?? true);
        $request->session()->put('options.background', $validated['background'] ?? 'transparent');
        $request->session()->put('options.useHeader', $validated['useHeader'] ?? true);
        $request->session()->put('options.headerButtons', $validated['headerButtons'] ?? true);
        $request->session()->put('options.headerText', $validated['headerText'] ?? '');

        $torchlight = new TorchlightSnippetGenerator($validated['code'], $validated['language'] ?? '', $validated['lineNumbers'] ?? true);
        $result = $torchlight->generate();

        $request->session()->put('result', $result);

        $request->session()->flash('generated');

        return redirect()->route('home');
    }

    /**
     * To improve the user experience, we store the input and result in the session.
     *
     * @return array{0: string|null, 1: string|null, 2: array{language: string, lineNumbers: bool}}
     */
    protected function getSessionData(): array
    {
        /** @var ?string $input */
        $input = old('code') ?? session('input');

        $options = [
            'language' => old('language') ?? session('options.language') ?? 'php',
            'lineNumbers' => old('lineNumbers') ?? session('options.lineNumbers') ?? true,
            'background' => old('background') ?? session('options.background') ?? 'transparent',
            'useHeader' => old('useHeader') ?? session('options.useHeader') ?? true,
            'headerButtons' => old('headerButtons') ?? session('options.headerButtons') ?? true,
            'headerText' => old('headerText') ?? session('options.headerText') ?? '',
            'generated' => session('generated') ?? false,
        ];

        /** @var ?string $result */
        $result = session('result');

        return [$input, $result, $options];
    }

    /**
     * In case the user has not entered any input, we provide an example.
     *
     * @return array{0: string, 1: string}
     */
    public function injectExamplesForEmptyState(?string $input, ?string $result): array
    {
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

        return [$input, $result];
    }
}
