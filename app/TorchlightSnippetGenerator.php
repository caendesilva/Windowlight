<?php

namespace App;

use App\Contracts\Torchlight;
use Illuminate\Support\Facades\Config;
use Torchlight\Block;
use Torchlight\Manager;

class TorchlightSnippetGenerator
{
    protected string $code;

    /** @var literal-string<Torchlight::LANGUAGES> */
    protected string $language;

    protected string $html;
    protected bool $lineNumbers = true;

    public function __construct(string $code, string $language, bool $lineNumbers = true)
    {
        $this->code = $code;
        $this->language = $language;
        $this->lineNumbers = $lineNumbers;
    }

    public function generate(): string
    {
        Config::set(['torchlight.options.lineNumbers' => $this->lineNumbers]);

        $block = new Block();
        $block->code($this->code);
        $block->language($this->language);

        $torchlight = new Manager();
        $blocks = $torchlight->highlight($block);
        $highlighted = $blocks[0];
        $this->html = $highlighted->wrapped;

        return $this->html;
    }
}
