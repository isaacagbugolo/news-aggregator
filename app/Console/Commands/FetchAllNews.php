<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Fetchers\NewsApiFetcher;
use App\Services\Fetchers\GuardianFetcher;
use App\Services\Fetchers\NYTFetcher;
use App\Models\Article;

class FetchAllNews extends Command
{
    protected $signature = 'news:fetch-all';
    protected $description = 'Fetch and store articles from all news sources';

    public function handle()
    {
        $sources = [
            NewsApiFetcher::class,
            GuardianFetcher::class,
            NYTFetcher::class,
        ];

        foreach ($sources as $fetcherClass) {
            $fetcher = new $fetcherClass();
            $articles = $fetcher->fetch();

            $count = 0;
            foreach ($articles as $a) {
                Article::updateOrCreate(['external_id' => $a['external_id']], $a);
                $count++;
            }

            $this->info("{$fetcherClass} stored {$count} articles.");
        }

        $this->info('✅ All sources fetched and stored successfully.');
        return 0;
    }
}
