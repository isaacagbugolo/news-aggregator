<?php
class FetchSourceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fetcher; // an implementation of FetcherInterface
    protected $sourceKey;
    protected $since;

    public function __construct(string $sourceKey, ?\DateTime $since = null)
    {
        $this->sourceKey = $sourceKey;
        $this->since = $since;
    }

    public function handle()
    {
        // instantiate appropriate fetcher - consider binding in service container via sourceKey
        $fetcher = match($this->sourceKey) {
            'newsapi' => new \App\Services\Fetchers\NewsApiFetcher(),
            'guardian' => new \App\Services\Fetchers\GuardianFetcher(),
            'nyt' => new \App\Services\Fetchers\NytFetcher(),
            default => null
        };
        if (!$fetcher) return;

        $articles = $fetcher->fetch($this->since);
        $agg = new \App\Services\AggregatorService();
        $agg->saveArticles($this->sourceKey, $articles);
    }
}
