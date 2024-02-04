<?php

namespace App\Contracts;

use Illuminate\Support\HtmlString;

class Torchlight
{
    /**
     * The available languages for Torchlight.
     *
     * Parsed from {@link https://torchlight.dev/docs/languages}.
     *
     * @var array<string>
     */
    public const LANGUAGES = ['abap', 'actionscript-3', 'ada', 'alpine', 'alpinejs', 'apex', 'applescript', 'asm', 'awk', 'bat', 'batch', 'c', 'csharp', 'c#', 'cpp', 'clojure', 'clj', 'cobol', 'coffee', 'crystal', 'css', 'curl', 'd', 'dart', 'dockerfile', 'elixir', 'elm', 'html-ruby-erb', 'erb', 'erlang', 'fsharp', 'f#', 'git-commit', 'diff', 'git-ignore', 'gitignore', 'git-rebase', 'gnuplot', 'go', 'graphql', 'groovy', 'hack', 'haml', 'handlebars', 'hbs', 'hcl', 'haskell', 'hlsl', 'html', 'ini', 'java', 'javascript', 'js', 'jinja-html', 'json', 'jsonc', 'jsonnet', 'jsx', 'julia', 'kotlin', 'blade', 'latex', 'tex', 'less', 'lisp', 'logo', 'lua', 'makefile', 'markdown', 'md', 'matlab', 'mdx', 'nix', 'objective-c', 'objc', 'ocaml', 'pascal', 'perl', 'perl6', 'php', '(null)', 'txt', 'text', 'plaintext', 'pls', 'postcss', 'powershell', 'ps', 'ps1', 'prolog', 'pug', 'jade', 'puppet', 'purescript', 'python', 'py', 'r', 'razor', 'ruby', 'rb', 'rust', 'sas', 'sass', 'scala', 'scheme', 'scss', 'shaderlab', 'shader', 'shell', 'smalltalk', 'sql', 'ssh-config', 'antlers', 'stylus', 'styl', 'swift', 'tcl', 'toml', 'tsx', 'typescript', 'ts', 'vb', 'cmd', 'viml', 'vue', 'wasm', '文言', 'wenyan', 'xml', 'xsl', 'yaml'];

    public static function languageListOptions(): HtmlString
    {
        return new HtmlString(implode('', array_map(function (string $languageOption): string {
            return sprintf('<option value="%s" />', $languageOption);
        }, self::LANGUAGES)));
    }
}
