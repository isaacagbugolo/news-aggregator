<?php
namespace App\Services;

use App\Services\Fetchers\FetcherInterface;
use App\Models\Source;
use App\Models\Author;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Support\Str;
use DB;

class AggregatorService
{
    protected $repo;

    public function __construct() {
        // you may inject a repository; keep simple for example
    }

    /**
     * Save normalized articles for a given source key.
     * $sourceKey should match sources.key in DB
     */
    public function saveArticles(string $sourceKey, array $articles)
    {
        $source = Source::firstWhere('key', $sourceKey) ??
                  Source::create(['key'=>$sourceKey,'name'=>Str::title($sourceKey)]);
        foreach ($articles as $a) {
            // Dedupe by url
            if (empty($a['url'])) continue;
            $exists = Article::where('url', $a['url'])->exists();
            if ($exists) continue;

            DB::transaction(function() use ($a, $source) {
                $author = null;
                if (!empty($a['author'])) {
                    $author = Author::firstOrCreate(['name' => $a['author']]);
                }
                $category = null;
                if (!empty($a['category'])) {
                    $category = Category::firstOrCreate(['name' => $a['category']]);
                }
                Article::create([
                    'source_id' => $source->id,
                    'author_id' => $author?->id,
                    'category_id' => $category?->id,
                    'external_id' => $a['external_id'] ?? null,
                    'title' => $a['title'] ?? '(no title)',
                    'description' => $a['description'] ?? null,
                    'content' => $a['content'] ?? null,
                    'url' => $a['url'],
                    'image_url' => $a['image_url'] ?? null,
                    'published_at' => $a['published_at'] ? now()->parse($a['published_at']) : null,
                    'raw' => $a['raw'] ?? null,
                ]);
            });
        }
    }
}
