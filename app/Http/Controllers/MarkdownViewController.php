<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MarkdownViewController extends Controller
{
    public function about(): View
    {
        return $this->showMarkdownPage('about');
    }

    public function examples(): View
    {
        return $this->showMarkdownPage('examples', [
            '{{ $examples }}' => $this->getExamples(),
        ]);
    }

    protected function showMarkdownPage(string $view, array $replace = []): View
    {
        return view('markdown', [
            'markdown' => new HtmlString(
                str_replace(array_keys($replace), array_values($replace), Str::markdown($this->getMarkdownContents($view)))
            )
        ]);
    }

    protected function getMarkdownContents(string $view): string
    {
        return file_get_contents(resource_path("markdown/$view.md"));
    }

    protected function getExamples(): string
    {
        $examples = Arr::mapWithKeys(array_reverse(glob(public_path('examples/windowlight-*.png'))), function (string $file): array {
            $source = asset('examples/' . basename($file));
            $contents = str_replace("\n", '&#10', e(trim(file_get_contents(str_replace('.png', '.txt', $file)))));

            return [
                $source => $contents,
            ];
        });

        return view('components.examples', compact('examples'))->render();
    }
}
