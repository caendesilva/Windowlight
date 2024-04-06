<?php

namespace App\Console\Commands\BuildTasks;

use App\Helpers\SitemapGenerator;
use Hyde\Framework\Actions\PostBuildTasks\GenerateSitemap as HydeGenerateSitemap;
use Hyde\Hyde;

class GenerateSitemap extends HydeGenerateSitemap
{
    public function handle(): void
    {
        file_put_contents(
            Hyde::sitePath('sitemap.xml'),
            SitemapGenerator::make()
        );
    }
}
