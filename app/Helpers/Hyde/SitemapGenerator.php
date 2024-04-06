<?php

namespace App\Helpers\Hyde;

use DOMDocument;
use Hyde\Foundation\Facades\Routes;
use Hyde\Framework\Features\XmlGenerators\SitemapGenerator as HydeSitemapGenerator;
use Hyde\Pages\MarkdownPost;
use Hyde\Support\Models\Route;

class SitemapGenerator extends HydeSitemapGenerator
{
    public function generate(): static
    {
        $routes = Routes::all();

        // Sort routes to put blog posts last
        $routes = $routes->sortBy(fn (Route $route): int => $route->getPage() instanceof MarkdownPost ? 1 : 0);

        $routes->each(function (Route $route): void {
            $this->addRoute($route);
        });

        return $this;
    }

    protected function getPriority(string $pageClass, string $slug): string
    {
        if ($slug === '/') {
            return '1.0';
        }

        if ($slug === 'about') {
            return '0.9';
        }

        if ($slug === 'examples') {
            return '0.75';
        }

        if ($slug === 'analytics') {
            return '0.6';
        }

        return parent::getPriority($pageClass, $slug);
    }

    public function getXml(): string
    {
        $this->xmlElement->addAttribute('generated_at', date('c', time()));

        return static::formatXmlString(parent::getXml());
    }

    protected static function formatXmlString(string $xml): string
    {
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml);

        return $dom->saveXML();
    }
}
