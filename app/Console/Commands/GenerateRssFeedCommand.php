<?php

namespace App\Console\Commands;

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
        //

        return Command::SUCCESS;
    }
}
