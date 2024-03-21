<?php

namespace App\Http\Controllers;

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
            'markdown' => new HtmlString(Str::markdown(
                str_replace(array_keys($replace), array_values($replace), $this->getMarkdownContents($view))
            ))
        ]);
    }

    protected function getMarkdownContents(string $view): string
    {
        return file_get_contents(resource_path("markdown/$view.md"));
    }

    protected function getExamples(): string
    {
        $output = '';

        foreach (glob(public_path('examples/windowlight-*.png')) as $file) {
            $altText = str_replace("\n", '&#10', e(trim(file_get_contents(str_replace('.png', '.txt', $file)))));

            $output .= sprintf('<img src="%s" alt="%s" title="%s">', asset('examples/' . basename($file)), $altText, $altText);
        }

        return $output;
    }
}
