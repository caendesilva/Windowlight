<?php

namespace App\Console\Commands;

use App\Providers\HydeServiceProvider;
use Hyde\Framework\Actions\PostBuildTasks\GenerateRssFeed;
use Illuminate\Console\Command;

/**
 * @see \Hyde\Console\Commands\BuildRssFeedCommand
 */
class GenerateRssFeedCommand extends Command
{
    /** @var string */
    protected $signature = 'build:rss';

    /** @var string */
    protected $description = 'Generate the RSS feed';

    public function handle(): int
    {
        app()->register(HydeServiceProvider::class);

        return (new GenerateRssFeed())->run($this->output);
    }
}
