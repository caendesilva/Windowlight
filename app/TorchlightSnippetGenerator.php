<?php

namespace App;

use App\Concerns\TorchlightData;

class TorchlightSnippetGenerator
{
    use TorchlightData;

    protected string $code;

    /** @var literal-string<self::LANGUAGES> */
    protected string $language;

    public function __construct(string $code, string $language)
    {
        $this->code = $code;
        $this->language = $language;
    }

    public function generate(): string
    {
        // TODO: Implement logic here

        return $this->code;
    }
}
