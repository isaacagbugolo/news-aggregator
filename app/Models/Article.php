<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    protected $fillable = [
        'external_id',
        'title',
        'description',
        'content',
        'url',
        'image_url',
        'published_at',
        'author_id',
        'category_id',
        'source_id',
        'raw',
    ];

    // Relationship to Author
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    // Relationship to Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship to Source
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }
}
