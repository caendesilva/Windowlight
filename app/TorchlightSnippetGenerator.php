<?php

namespace App;

use App\Concerns\TorchlightData;

class TorchlightSnippetGenerator
{
    use TorchlightData;

    protected string $code;
    protected string $language;

    public function __construct(string $code, string $language)
    {
        $this->code = $code;
        $this->language = $language;
    }
}
