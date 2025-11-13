<?php

namespace App\Services\Fetchers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Author;
use App\Models\Category;
use App\Models\Article;

class NYTFetcher
{
    protected string $apiKey;
    protected string $endpoint;

    public function __construct()
    {
        // Get the NYT API key from config/services.php or .env
        $this->apiKey = config('services.nyt.key') ?? env('NYT_KEY');

        if (!$this->apiKey) {
            throw new \Exception('NYT API key not found in config/services.php or .env');
        }

        $this->endpoint = 'https://api.nytimes.com/svc/search/v2/articlesearch.json';
    }

    /**
     * Fetch and store NYT articles
     *
     * @return array
     */
    public function fetch(): array
    {
        try {
            // Request the latest articles about technology
            $response = Http::get($this->endpoint, [
                'q' => 'technology',
                'sort' => 'newest',
                'api-key' => $this->apiKey,
            ]);

            if ($response->failed()) {
                Log::error('NYT Fetch failed: ' . $response->body());
                return [];
            }

            $json = $response->json();
            Log::info('NYT raw response', ['json' => $json]);

            $articles = $json['response']['docs'] ?? [];
            $normalized = [];

            foreach ($articles as $item) {
                // Normalize author
                $authorName = $item['byline']['original'] ?? 'Unknown';
                $author = Author::firstOrCreate(['name' => $authorName]);

                // Normalize category/section
                $categoryName = $item['section_name'] ?? 'General';
                $category = Category::firstOrCreate(['name' => $categoryName]);

                 // Normalize source
                $source = \App\Models\Source::firstOrCreate(
                ['slug' => 'nyt'],
                ['name' => 'New York Times', 'url' => 'https://www.nytimes.com']
                );

                // Normalize multimedia image (take first if exists)
                $imageUrl = null;
                if (!empty($item['multimedia']) && isset($item['multimedia'][0]['url'])) {
                    $imageUrl = 'https://www.nytimes.com/' . $item['multimedia'][0]['url'];
                }

                // Convert NYT ISO datetime to MySQL DATETIME
                $publishedAt = isset($item['pub_date'])
                    ? date('Y-m-d H:i:s', strtotime($item['pub_date']))
                    : null;

                // Prepare normalized article
                $normalized[] = [
                    'external_id' => $item['_id'] ?? null,
                    'title' => $item['headline']['main'] ?? null,
                    'description' => $item['abstract'] ?? null,
                    'content' => $item['lead_paragraph'] ?? null,
                    'url' => $item['web_url'] ?? null,
                    'image_url' => $imageUrl,
                    'published_at' => $publishedAt,
                    'author_id' => $author->id,
                    'category_id' => $category->id,
                    'raw' => $item,
                ];
            }

            // Store in database safely
            foreach ($normalized as $article) {
                Article::updateOrCreate(['external_id' => $article['external_id']], $article);
            }

            Log::info('NYTFetcher fetched and stored ' . count($normalized) . ' articles.');

            return $normalized;

        } catch (\Throwable $e) {
            Log::error('NYT Fetch error: ' . $e->getMessage());
            return [];
        }
    }
}
