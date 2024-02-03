<?php

namespace App;

class TorchlightSnippetGenerator
{
    protected string $code;
    protected string $language;

    public function __construct(string $code, string $language)
    {
        $this->code = $code;
        $this->language = $language;
    }
}
