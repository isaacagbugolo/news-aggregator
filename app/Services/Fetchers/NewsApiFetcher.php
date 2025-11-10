<?php
namespace App\Services\Fetchers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Models\Author;
use App\Models\Category;
use App\Models\Article;

class NewsApiFetcher implements FetcherInterface
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.newsapi.key') ?? env('NEWSAPI_KEY');
        $this->client = new Client(['base_uri' => 'https://newsapi.org/']);
    }

    public function fetch(\DateTime $since = null): array
    {
        $params = [
            'apiKey' => $this->apiKey,
            'language' => 'en',
            'pageSize' => 100,
            'q' => 'news',
        ];

        if ($since) {
            $params['from'] = $since->format(DATE_ATOM);
        }

        try {
            $resp = $this->client->get('v2/everything', ['query' => $params]);
            $json = json_decode((string)$resp->getBody(), true);
            $items = $json['articles'] ?? [];

            Log::info('NewsAPI fetch count: ' . count($items));

            $normalized = [];

            foreach ($items as $it) {
                $authorName = $it['author'] ?? 'Unknown';
                $categoryName = 'General';

                $author = Author::firstOrCreate(['name' => $authorName]);
                $category = Category::firstOrCreate(['name' => $categoryName]);

                 // Normalize source
    $source = \App\Models\Source::firstOrCreate(
        ['slug' => 'nyt'],
        ['name' => 'New York Times', 'url' => 'https://www.nytimes.com']
    );

                $normalized[] = [
                    'external_id' => $it['url'],
                    'title' => $it['title'],
                    'description' => $it['description'],
                    'content' => $it['content'],
                    'url' => $it['url'],
                    'image_url' => $it['urlToImage'] ?? null,
                    'published_at' => isset($it['publishedAt']) 
                    ? date('Y-m-d H:i:s', strtotime($it['publishedAt'])) 
                    : null,
                    'author_id' => $author->id,
                    'category_id' => $category->id,
                    'raw' => $it,
                ];
            }

            Log::info("App\Services\Fetchers\NewsApiFetcher fetched " . count($normalized) . " articles.");
            return $normalized;

        } catch (\Exception $e) {
            Log::error('NewsAPI fetch error: ' . $e->getMessage());
            return [];
        }
    }
}
