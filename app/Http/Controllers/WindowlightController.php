<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateRequest;
use App\Models\Analytics\CodeGenerationEvent;
use App\TorchlightSnippetGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * The controller for the Windowlight code snippet generator.
 *
 * Improvement ideas: (PRs welcome!)
 *
 * Todo: Support multiple background shadow sizes
 * Todo: Support multiple padding sizes
 * Todo: Support background gradients
 * Todo: Support background images
 */
class WindowlightController extends Controller
{
    public function show(): View
    {
        [$input, $result, $options] = $this->getSessionData();

        [$input, $result] = $this->injectExamplesForEmptyState($input, $result);

        return view('windowlight', array_merge([
            'input' => $input,
            'result' => $result,
            'resultId' => $this->makeResultId($result, $options),
        ], $options));
    }

    public function store(GenerateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $request->session()->put('input', $validated['code']);
        $request->session()->put('options.language', $validated['language'] ?? '');
        $request->session()->put('options.lineNumbers', $validated['lineNumbers'] ?? true);
        $request->session()->put('options.background', $validated['background'] ?? 'transparent');
        $request->session()->put('options.useHeader', $validated['useHeader'] ?? true);
        $request->session()->put('options.useShadow', $validated['useShadow'] ?? false);
        $request->session()->put('options.headerButtons', $validated['headerButtons'] ?? true);
        $request->session()->put('options.headerText', $validated['headerText'] ?? '');

        $torchlight = new TorchlightSnippetGenerator(
            $validated['code'],
            $validated['language'] ?? '',
            $validated['lineNumbers'] ?? true
        );

        $result = $torchlight->generate();

        $request->session()->put('result', $result);
        $request->session()->flash('generated');

        CodeGenerationEvent::create([
            'language' => $validated['language'] ?? '',
            'hasMenubar' => $validated['useHeader'] ?? true,
            'hasLineNumbers' => $validated['lineNumbers'] ?? true,
            'hasMenuButtons' => $validated['headerButtons'] ?? true,
            'hasMenubarText' => $validated['headerText'] ?? '',
            'background' => $validated['background'] ?? 'transparent',
            'lines' => substr_count($validated['code'], "\n") + 1,
        ]);

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
            'useShadow' => old('useShadow') ?? session('options.useShadow') ?? false,
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
    protected function injectExamplesForEmptyState(?string $input, ?string $result): array
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

    protected function makeResultId(string $result, array $options): string
    {
        return hash('sha256', $result.json_encode($options));
    }
}
