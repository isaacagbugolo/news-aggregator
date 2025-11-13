<?php
namespace App\Services\Fetchers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Models\Author;
use App\Models\Category;
use App\Models\Article;

class GuardianFetcher implements FetcherInterface
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.guardian.key') ?? env('GUARDIAN_KEY');
        $this->client = new Client(['base_uri' => 'https://content.guardianapis.com/']);
    }

    public function fetch(\DateTime $since = null): array
    {
        $params = [
            'api-key' => $this->apiKey,
            'show-fields' => 'headline,trailText,bodyText,thumbnail,byline',
            'page-size' => 50,
        ];

        if ($since) {
            $params['from-date'] = $since->format('Y-m-d');
        }

        try {
            $resp = $this->client->get('search', ['query' => $params]);
            $json = json_decode((string)$resp->getBody(), true);
            $items = $json['response']['results'] ?? [];

            Log::info('Guardian fetch count: ' . count($items));

            $normalized = [];

            foreach ($items as $it) {
                $fields = $it['fields'] ?? [];
                $authorName = $fields['byline'] ?? 'Unknown';
                $categoryName = $it['sectionName'] ?? 'General';

                $author = Author::firstOrCreate(['name' => $authorName]);
                $category = Category::firstOrCreate(['name' => $categoryName]);

                 // Normalize source
    $source = \App\Models\Source::firstOrCreate(
        ['slug' => 'nyt'],
        ['name' => 'New York Times', 'url' => 'https://www.nytimes.com']
    );

                $normalized[] = [
                    'external_id' => $it['id'],
                    'title' => $fields['headline'] ?? $it['webTitle'],
                    'description' => $fields['trailText'] ?? null,
                    'content' => $fields['bodyText'] ?? null,
                    'url' => $it['webUrl'],
                    'image_url' => $fields['thumbnail'] ?? null,
                    'published_at' => isset($it['publishedAt']) 
                    ? date('Y-m-d H:i:s', strtotime($it['publishedAt'])) 
                    : null,
                    'author_id' => $author->id,
                    'category_id' => $category->id,
                    'raw' => $it,
                ];
            }

            Log::info("App\Services\Fetchers\GuardianFetcher fetched " . count($normalized) . " articles.");
            return $normalized;

        } catch (\Exception $e) {
            Log::error('Guardian fetch error: ' . $e->getMessage());
            return [];
        }
    }
}
