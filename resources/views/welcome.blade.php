<!DOCTYPE html>
<html>
<head>
    <title>News Aggregator</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <h1>Latest Articles</h1>

    @if($articles->isEmpty())
        <p>No articles found.</p>
    @else
        @foreach($articles as $article)
            <div class="article-card" style="border:1px solid #ccc; padding:15px; margin-bottom:10px;">
                <h2>{{ $article->title }}</h2>
                <p><strong>Author:</strong> {{ $article->author->name ?? 'Unknown' }}</p>
                <p><strong>Category:</strong> {{ $article->category->name ?? 'General' }}</p>
                <p><strong>Source:</strong> {{ $article->source->name ?? 'Unknown' }}</p>
                <p><strong>Published At:</strong> 
    {{ \Carbon\Carbon::parse($article->published_at)->format('M d, Y H:i') ?? 'N/A' }}
</p>
                <p>{{ $article->description ?? '' }}</p>
                <a href="{{ $article->url }}" target="_blank">Read full article</a>
            </div>
        @endforeach
    @endif
</body>
</html>
