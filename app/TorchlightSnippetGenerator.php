<?php

namespace App;

use App\Concerns\TorchlightData;
use Torchlight\Block;
use Torchlight\Manager;

class TorchlightSnippetGenerator
{
    use TorchlightData;

    protected string $code;

    /** @var literal-string<self::LANGUAGES> */
    protected string $language;

    protected string $html;

    public function __construct(string $code, string $language)
    {
        $this->code = $code;
        $this->language = $language;
    }

    public function generate(): string
    {
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
