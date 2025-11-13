<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Source;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $q = Article::with(['source','author','category']);
        // search query
        if ($request->filled('q')) {
            $term = $request->q;
            $q->where(function($r) use ($term) {
                $r->where('title','like','%'.$term.'%')
                  ->orWhere('description','like','%'.$term.'%')
                  ->orWhere('content','like','%'.$term.'%');
            });
        }
        // filter by date range
        if ($request->filled('from')) $q->where('published_at','>=', $request->from);
        if ($request->filled('to')) $q->where('published_at','<=', $request->to);
        // filter by category
        if ($request->filled('category')) {
            $q->whereHas('category', fn($s) => $s->where('name', $request->category));
        }
        // filter by source key
        if ($request->filled('source')) {
            $q->whereHas('source', fn($s) => $s->where('slug', $request->source));
        }
        // user preference selected sources: optional; if user pref provided, restrict
        if ($request->filled('sources')) {
            $sources = explode(',', $request->sources);
            $q->whereHas('source', fn($s) => $s->whereIn('slug', $sources));
        }

        $perPage = (int) $request->get('per_page', 20);
        $articles = $q->orderBy('published_at','desc')->paginate($perPage);

        return response()->json($articles);
    }

    public function show($id)
    {
        $article = Article::with(['source','author','category'])->findOrFail($id);
        return response()->json($article);
    }

    public function sources()
    {
        return response()->json(Source::all());
    }
}
