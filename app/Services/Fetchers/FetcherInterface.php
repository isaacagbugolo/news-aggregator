<?php
namespace App\Services\Fetchers;

interface FetcherInterface {
    /**
     * Fetch latest articles (or for a given since date).
     * @param \DateTime|null $since
     * @return array[]  array of normalized article arrays with keys:
     *  title, description, content, url, image_url, published_at (ISO8601), author, category, external_id, raw
     */
    public function fetch(\DateTime $since = null): array;
}
