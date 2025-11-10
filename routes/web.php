<?php

use Illuminate\Support\Facades\Route;
use App\Models\Article; // ✅ Add this line

Route::get('/', function () {
    $articles = Article::with(['author', 'category', 'source'])
                      ->orderBy('published_at', 'desc')
                      ->take(10) // show latest 10 articles
                      ->get();

    return view('welcome', compact('articles'));
});
