<?php

namespace 34ML\SEO\Commands;

use Illuminate\Console\Command;

class SEOCommand extends Command
{
    public $signature = 'laravel-seo';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
