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
        /** @var ?string $result */
        $result = session('result');

        $example = <<<'PHP'
        <?php
        
        use Illuminate\Support\Facades\Route;
        
        Route::get('/greeting', function () {
            return 'Hello World';
        });
        PHP;

        if ($result === null) {
            $result = (new TorchlightSnippetGenerator($example, 'php'))->generate();
        }

        return view('windowlight', [
            'result' => $result,
            'example' => $example
        ]);
    }

    public function store(CreateImageRequest $request)
    {
        $validated = $request->validated();

        $torchlight = new TorchlightSnippetGenerator($validated['code'], 'php');
        $result = $torchlight->generate();

        // Store in session
        $request->session()->put('result', $result);

        return redirect()->route('home');
    }
}
